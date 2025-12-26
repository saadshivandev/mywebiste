<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <svg viewBox="0 0 341 65" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto fill-gray-700 dark:fill-gray-200">
                        <path d="M175.622 0.97168C175.622 0.97168 194.247 20.281 194.247 35.0001C194.247 49.7192 175.622 64.0284 175.622 64.0284C175.622 64.0284 157.247 49.7192 157.247 35.0001C157.247 20.281 175.622 0.97168 175.622 0.97168Z"/>
                        <path d="M0 35.0001C0 35.0001 18.625 54.3093 18.625 64.0284C18.625 73.7475 0 64.0284 0 64.0284C0 64.0284 0 49.7192 0 35.0001Z"/>
                        <path d="M18.6235 0.97168C18.6235 0.97168 37.2485 20.281 37.2485 35.0001C37.2485 49.7192 18.6235 64.0284 18.6235 64.0284C18.6235 64.0284 0 49.7192 0 35.0001C0 20.281 18.6235 0.97168 18.6235 0.97168Z"/>
                        <path d="M194.248 0.97168C194.248 0.97168 212.873 20.281 212.873 35.0001C212.873 49.7192 194.248 64.0284 194.248 64.0284C194.248 64.0284 175.622 49.7192 175.622 35.0001C175.622 20.281 194.248 0.97168 194.248 0.97168Z"/>
                        <path d="M37.248 35.0001C37.248 35.0001 55.873 54.3093 55.873 64.0284C55.873 73.7475 37.248 64.0284 37.248 64.0284C37.248 64.0284 18.6235 49.7192 18.6235 35.0001C18.6235 20.281 37.248 35.0001 37.248 35.0001Z"/>
                        <path d="M55.873 0.97168C55.873 0.97168 74.498 20.281 74.498 35.0001C74.498 49.7192 55.873 64.0284 55.873 64.0284C55.873 64.0284 37.248 49.7192 37.248 35.0001C37.248 20.281 55.873 0.97168 55.873 0.97168Z"/>
                        <path d="M74.498 35.0001C74.498 35.0001 93.123 54.3093 93.123 64.0284C93.123 73.7475 74.498 64.0284 74.498 64.0284C74.498 64.0284 55.873 49.7192 55.873 35.0001C55.873 20.281 74.498 35.0001 74.498 35.0001Z"/>
                        <path d="M93.123 0.97168C93.123 0.97168 111.748 20.281 111.748 35.0001C111.748 49.7192 93.123 64.0284 93.123 64.0284C93.123 64.0284 74.498 49.7192 74.498 35.0001C74.498 20.281 93.123 0.97168 93.123 0.97168Z"/>
                        <path d="M111.748 35.0001C111.748 35.0001 130.373 54.3093 130.373 64.0284C130.373 73.7475 111.748 64.0284 111.748 64.0284C111.748 64.0284 93.123 49.7192 93.123 35.0001C93.123 20.281 111.748 35.0001 111.748 35.0001Z"/>
                        <path d="M130.373 0.97168C130.373 0.97168 148.998 20.281 148.998 35.0001C148.998 49.7192 130.373 64.0284 130.373 64.0284C130.373 64.0284 111.748 49.7192 111.748 35.0001C111.748 20.281 130.373 0.97168 130.373 0.97168Z"/>
                        <path d="M148.998 35.0001C148.998 35.0001 167.623 54.3093 167.623 64.0284C167.623 73.7475 148.998 64.0284 148.998 64.0284C148.998 64.0284 130.373 49.7192 130.373 35.0001C130.373 20.281 148.998 35.0001 148.998 35.0001Z"/>
                        <path d="M167.623 0.97168C167.623 0.97168 186.248 20.281 186.248 35.0001C186.248 49.7192 167.623 64.0284 167.623 64.0284C167.623 64.0284 148.998 49.7192 148.998 35.0001C148.998 20.281 167.623 0.97168 167.623 0.97168Z"/>
                        <path d="M186.248 35.0001C186.248 35.0001 204.873 54.3093 204.873 64.0284C204.873 73.7475 186.248 64.0284 186.248 64.0284C186.248 64.0284 167.623 49.7192 167.623 35.0001C167.623 20.281 186.248 35.0001 186.248 35.0001Z"/>
                        <path d="M212.873 0.97168C212.873 0.97168 231.498 20.281 231.498 35.0001C231.498 49.7192 212.873 64.0284 212.873 64.0284C212.873 64.0284 194.248 49.7192 194.248 35.0001C194.248 20.281 212.873 0.97168 212.873 0.97168Z"/>
                        <path d="M231.498 35.0001C231.498 35.0001 250.123 54.3093 250.123 64.0284C250.123 73.7475 231.498 64.0284 231.498 64.0284C231.498 64.0284 212.873 49.7192 212.873 35.0001C212.873 20.281 231.498 35.0001 231.498 35.0001Z"/>
                        <path d="M250.123 0.97168C250.123 0.97168 268.748 20.281 268.748 35.0001C268.748 49.7192 250.123 64.0284 250.123 64.0284C250.123 64.0284 231.498 49.7192 231.498 35.0001C231.498 20.281 250.123 0.97168 250.123 0.97168Z"/>
                        <path d="M268.748 35.0001C268.748 35.0001 287.373 54.3093 287.373 64.0284C287.373 73.7475 268.748 64.0284 268.748 64.0284C268.748 64.0284 250.123 49.7192 250.123 35.0001C250.123 20.281 268.748 35.0001 268.748 35.0001Z"/>
                        <path d="M287.373 0.97168C287.373 0.97168 305.998 20.281 305.998 35.0001C305.998 49.7192 287.373 64.0284 287.373 64.0284C287.373 64.0284 268.748 49.7192 268.748 35.0001C268.748 20.281 287.373 0.97168 287.373 0.97168Z"/>
                        <path d="M305.998 35.0001C305.998 35.0001 324.623 54.3093 324.623 64.0284C324.623 73.7475 305.998 64.0284 305.998 64.0284C305.998 64.0284 287.373 49.7192 287.373 35.0001C287.373 20.281 305.998 35.0001 305.998 35.0001Z"/>
                        <path d="M324.623 0.97168C324.623 0.97168 343.248 20.281 343.248 35.0001C343.248 49.7192 324.623 64.0284 324.623 64.0284C324.623 64.0284 305.998 49.7192 305.998 35.0001C305.998 20.281 324.623 0.97168 324.623 0.97168Z"/>
                        <path d="M341 35.0001C341 35.0001 341 49.7192 341 64.0284C341 64.0284 341 64.0284 341 64.0284C341 64.0284 324.623 49.7192 324.623 35.0001C324.623 20.281 341 35.0001 341 35.0001Z"/>
                    </svg>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <a href="https://laravel.com/docs" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-black/50 flex focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Documentation</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Laravel has wonderful documentation covering every aspect of the framework. Whether you're a beginner or have prior experience with Laravel, we recommend reading our documentation from beginning to end.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 ml-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                    </svg>
                                </a>

                        <a href="https://laracasts.com" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-black/50 flex focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                        <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Laracasts</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 ml-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                    </svg>
                                </a>

                        <a href="https://laravel-news.com" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-black/50 flex focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v4.5H6v-4.5z" />
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Laravel News</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 ml-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-black/50 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.1l.392.313.392-.313a6 6 0 011.653-2.997L12 6.5l.534.997a6 6 0 011.653 2.997l.392.313.392-.313a6 6 0 011.653-2.997L17.385 5.19A17.976 17.976 0 0012 3c-2.088 0-4.085.576-5.885 1.19z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.5a9 9 0 00-8.77 7.5 9 9 0 0017.54 0 9 9 0 00-8.77-7.5z" />
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Vibrant Ecosystem</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Laravel's robust library of first-party tools and libraries, such as <a href="https://forge.laravel.com" class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Forge</a>, <a href="https://vapor.laravel.com" class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Vapor</a>, <a href="https://nova.laravel.com" class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Nova</a>, and <a href="https://envoyer.io" class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Envoyer</a> help you take your projects to the next level.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
                        <div class="flex items-center gap-4">
                            <a href="https://www.facebook.com/laravelphp" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="-mt-0.5 h-5 w-5 stroke-gray-400 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.68c0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 00-.75.75v.68M7.5 18.45l4.5-4.5 4.5 4.5 2.25-2.25L12 9.75l-6.75 6.45 2.25 2.25zM3.75 15.45v4.5a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 00-.75.75z" />
                    </svg>
                            </a>

                            <a href="https://twitter.com/laravelphp" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="-mt-0.5 h-5 w-5 stroke-gray-400 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

