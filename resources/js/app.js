import './bootstrap';

import AirDatepicker from 'air-datepicker';
import 'air-datepicker/air-datepicker.css';
import localeEn from 'air-datepicker/locale/en';

var datepickers = $(".datetimeplugin");

$.each(datepickers,function (index,item) {
    new AirDatepicker(item,{
        locale:localeEn,
        timepicker:true
    });
});

