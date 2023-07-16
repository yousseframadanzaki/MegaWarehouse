<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mega Login</title>
    @vite(['resources/sass/app.scss','resources/js/app.js'])
</head>
<body>
    <main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Mega Warehouse</h1>
						</div>

						<div class="card shadow">
							<div class="card-body">
								<div class="m-sm-3">
									<form action="{{route('login')}}" method="POST">
                                        @csrf
                                        @error('error')
                                        <div class="alert alert-danger" role="alert">
                                            {{__($message)}}
                                        </div>
                                        @enderror
										<div class="mb-3">
											<label class="form-label">الايميل او رقم التليفون</label>
                                            <div class="input-group has-validation">
                                                <input class="form-control form-control-lg @error('identity') is-invalid @enderror" name="identity" id="identity" />
                                                @error('identity')
                                                <div class="invalid-feedback">
                                                    {{__($message)}}
                                                </div>
                                                @enderror
                                            </div>
										</div>
										<div class="mb-3">
											<label class="form-label">كلمة السر</label>
                                            <div class="input-group has-validation">
                                                <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" name="password" />
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{__($message)}}
                                                    </div>
                                                @enderror
										    </div>
										</div>
										
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary">تسجيل الدخول</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</main>

    {{-- <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        تسجيل الدخول
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{url('/login')}}" method="POST">
                        @error('error')
                            <p class="text-red-500 text-xs italic">{{__($message)}}</p>
                        @enderror
                        @csrf
                        <div>
                            <label for="identity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">الايميل او رقم التليفون</label>
                            <input name="identity" id="identity" class="bg-gray-50 @error('identity')border-2 border-red-500 @enderror border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @error('identity')<p class="text-red-500 text-xs italic">{{__($message)}}</p>@enderror
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">كلمة السر</label>
                            <input type="password" name="password" id="password" placeholder="" class="bg-gray-50 @error('password') border-2 border-red-500 @enderror border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                            @error('password')<p class="text-red-500 text-xs italic">{{__($message)}}</p>@enderror
                        </div>
                        <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">تسجيل الدخول</button>
                    </form>
                </div>
            </div>
        </div>
      </section> --}}
</body>
</html>