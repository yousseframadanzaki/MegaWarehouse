<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WhatsappCampaign;
use App\Models\WhatsappDevice;
use App\Models\Order;
use Carbon\Carbon;


class SendWhatsappMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-whatsapp-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled WhatsApp messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $campaigns = WhatsappCampaign::whereNotIn('status', ['hold', 'finished'])
            ->where('schedule_date', '<=', $now)
            ->get();
            // $Entry = "Is: {$campaigns}" . PHP_EOL;
            // file_put_contents(storage_path('app/campaigns_logs.txt'), $Entry, FILE_APPEND);
    
        foreach ($campaigns as $campaign) {
            $device = WhatsappDevice::where('user_id', $campaign->user_id)->first();
    
            $unsentNumbers = json_decode($campaign->unsent_numbers, true);
            $sendNumbers = $campaign->sent_numbers ? json_decode($campaign->sent_numbers, true) : [];
            
            if (!is_array($sendNumbers)) {
                $sendNumbers = [];
            }
    
            $delay = explode(",", trim($campaign->delay));
            $delayFrom = 0;
            $delayTo = 0;
    
            if (count($delay) === 2) {
                $delayFrom = (int)trim($delay[0]);
                $delayTo = (int)trim($delay[1]);
            }
    
            foreach ($unsentNumbers as $key => $numberData) {
                $number = $numberData['number'];
    
                if (in_array($number, array_column($sendNumbers, 'number'))) {
                    continue;
                }
    
                $order = Order::find($numberData['order_id']);
                $replace = [
                    $order->order_code,
                    $order->waybill,
                    $order->name,
                    $order->phone_1,
                    $order->phone_2,
                    $order->address,
                    $order->city->name,
                    $order->area->name,
                    $order->total,
                    $order->status->name 
                ];
    
                $find = [
                    '#order_id',
                    '#waybill',
                    '#client_name',
                    '#client_phone_1',
                    '#client_phone_2',
                    '#address',
                    '#city',
                    '#area',
                    '#total',
                    '#status'
                ];
    
                $campaignText = str_replace($find, $replace, $campaign->text);
    
                $response = $this->sendMessage($numberData['number'], $campaignText, $campaign->media, $device->instance_id);
    
                if ($response && isset($response['status'])) {
                    $numberData['status'] = $response['status'] == 'success' ? "1" : "0";
                } else {
                    $numberData['status'] = "0";
                }
    
                // $logEntry = "Number: {$numberData['number']}, Status: {$numberData['status']}" . PHP_EOL;
                // file_put_contents(storage_path('app/campaign_logs.txt'), $logEntry, FILE_APPEND);
    
                $sendNumbers[] = $numberData;
                unset($unsentNumbers[$key]);
    
                $campaign->unsent_numbers = json_encode(array_values($unsentNumbers));
                $campaign->sent_numbers = json_encode($sendNumbers);
                $campaign->save();
    
                $newDelay = rand($delayFrom, $delayTo);
                $campaign->next_time = $now->addSeconds($newDelay);
                $campaign->save();
    
                break;
            }
    
            if (empty($unsentNumbers)) {
                $campaign->status = 'finished';
                $campaign->save();
            }
        }
    }
    protected function sendMessage($number, $text, $media = null, $instance_id)
    {
        $access_token = '6450f3b188e73';
        $site_url = request()->getHost();

        if ($media) {
            $media_url = $site_url . "/templates/default/uploads/whatsapp/" . $media;
            $url = "https://whatsbotcloud.com/api/send?type=media&number=2" . $number . "&message=" . urlencode($text) . "&media_url=" . urlencode($media_url) . "&instance_id=" . $instance_id . "&access_token=" . $access_token;
        } else {
            $url = "https://whatsbotcloud.com/api/send?type=text&number=2" . $number . "&message=" . urlencode($text) . "&instance_id=" . $instance_id . "&access_token=" . $access_token;
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
        ));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}
