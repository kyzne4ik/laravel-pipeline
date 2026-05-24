<!DOCTYPE html>
<html>
<head>
	<title>ОчУмелые ручки - @yield('title')</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}">
    <style>
        .notifications-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .notification {
            min-width: 250px;
            padding: 15px 40px 15px 20px;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            cursor: pointer;
            animation: slideInUp 0.5s ease-out forwards;
            position: relative;
            overflow: hidden;
        }

        .notification .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 20px;
            line-height: 20px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .notification .close-btn:hover {
            opacity: 1;
        }

        .notification--success {
            background-color: #28a745;
        }

        .notification--error {
            background-color: #dc3545;
        }

        .notification.hiding {
            animation: slideOutDown 0.5s ease-in forwards;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideOutDown {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(100%);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="dp">
	<div class="header">
		<div class="row grid middle between">
			<div class="logo">
				<a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}"></a>
			</div>
			<div class="title">
				Клуб любителей творчества «ОчУмелые ручки»
			</div>
			<div class="auth">
                @guest
                <span>
				    <span>
						<a href="{{ route('login') }}">Вход</a>
					</span>
					<span>/</span>
					<span>
					    <a href="{{ route('register') }}">Регистрация</a>
					</span>
                </span>
                @else
                    @if(Auth::user()->role === 'instructor')
                        <a href="{{ route('cabinet') }}">Кабинет</a> |
                    @endif
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
			</div>
		</div>
	</div>
	<div class="row row--nogutter">
		<div class="menu-burger">
			<div class="burger">
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
	</div>
	<div class="main">
		@if(Request::routeIs('master-classes.create', 'master-classes.edit'))
			<div class="row row--nogutter">
				<div class="line"></div>
			</div>
		@endif
		<div class="row">
		@if(!Request::routeIs('master-classes.create', 'master-classes.edit'))
			<div class="hover"></div>
			<div class="title">@yield('page_title')</div>
                   @endif
			<div class="row--small grid between">
				<div class="content 
					{{ Request::routeIs('cabinet') ? 'driver-page' : '' }}
					{{ Request::routeIs('master-classes.create') ? 'content-form-add-master-class' : '' }}
					{{ Request::routeIs('master-classes.edit') ? 'content-form-edit-master-class' : '' }}
					{{ Request::routeIs('login') ? 'content-login' : '' }}
					{{ Request::routeIs('register') ? 'content-register' : '' }}" 
					{!! Request::routeIs('master-classes.create', 'master-classes.edit', 'login', 'register') ? 'style="max-width: 100%; flex: 1; box-shadow: none;"' : '' !!}>
					@yield('content')
				</div>
				<ul class="menu" @if(Request::routeIs('master-classes.create', 'master-classes.edit')) style="display: none;" @endif>
                   @if(!Request::routeIs('master-classes.create', 'master-classes.edit', 'login', 'register'))
                       @foreach($sharedActivities as $activity)
                           <li><a href="{{ route('activity.show', $activity->id) }}">{{ $activity->title }}</a></li>
                       @endforeach
                       @yield('menu_extra')
                   @endif
				</ul>
			</div>
           @yield('after_main')
		</div>
</div>
<div class="row row--nogutter">
		<div class="line"></div>
</div>
	<div class="footer">
		<div class="row">
		<div class="row row--small grid between">
			<div class="address">Наш адрес: ВДНХ, 120в</div>
			<div class="tel">Тел: 89123456765</div>
			<div class="copy">(с) Copyright, 2017</div>
		</div>
	</div>

    <div class="notifications-container" id="notifications-container">
        @if (session('success'))
            <div class="notification notification--success" onclick="closeNotification(this)">
                <span class="close-btn">&times;</span>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="notification notification--error" onclick="closeNotification(this)">
                    <span class="close-btn">&times;</span>
                    {{ $error }}
                </div>
            @endforeach
        @endif
    </div>

    <script>
        function closeNotification(el) {
            if (el.classList.contains('hiding')) return;
            el.classList.add('hiding');
            setTimeout(() => el.remove(), 500);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                setTimeout(() => {
                    closeNotification(notification);
                }, 5000);
            });
        });
    </script>
</body>
</html>
