<?php
$locale = app()->getLocale();
?>
@extends('front.template')

@section('style')
    <link rel="stylesheet" href="/css/front/profile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">
@endsection

@section('body')
    <div class="login_container">
        <div class="orders_info">
            <h2>{{trans('front.profile.your_orders')}}</h2>
            <div class="orders_list">
                @foreach($orders as $order)
                    @include('front.template-parts.profile-order', ['order' => $order])
                @endforeach
            </div>
            <button id="load-more-orders"
                    data-current-page="1"
                    data-max-pages="{{$orders->lastPage()}}">
                {{trans('front.order.load_more')}}
                <svg fill="#000000" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M7 12v-2l-4 3 4 3v-2h2.997A6.006 6.006 0 0 0 16 8h-2a4 4 0 0 1-3.996 4H7zM9 2H6.003A6.006 6.006 0 0 0 0 8h2a4 4 0 0 1 3.996-4H9v2l4-3-4-3v2z"
                            fill-rule="evenodd"></path>
                    </g>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('front.profile.update') }}" id="profile-form"
              enctype="multipart/form-data">
            <h1>Edit Profile</h1>
            @csrf
            <div class="avatar-upload">
                <label for="avatar-input" class="avatar-label" style="display: block; cursor: pointer;">
                    <div
                        id="avatar-preview"
                        class="avatar-img"
                        style="width: 120px; height: 120px; border-radius: 50%; background-size: cover; background-position: center; background-image: url('{{ $user->getFirstMediaUrl('avatar') ?: asset('images/site/profile/acc_preview.svg') }}');"
                    ></div>
                    <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display: none;">
                </label>
                <button type="button" id="remove-avatar-btn" style="margin-top: 10px;"
                        class="{{$user->getFirstMediaUrl('avatar')?'':'disabled'}}">{{trans('front.profile.remove_avatar')}}
                </button>
                <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">
            </div>
            <input type="text" name="name" value="{{ $user->name }}" placeholder="Name" required>
            <input type="email" name="email" value="{{ $user->email }}" placeholder="Email" required>

            <input type="hidden" name="phone" id="full_phone">
            <input type="tel" id="phone" placeholder="Phone" value={{$user->phone}}>
            @if ($errors->any())
                <div class="error_message">Invalid data provided. Please check your inputs.</div>
            @endif

            @if (session('success'))
                <div class="success_message">Profile updated successfully!</div>
            @endif

            <button class="button_submit" type="submit">{{trans('front.profile.update_profile')}}</button>
        </form>
    </div>
    <form class="logout" method="POST" action="{{ route('front.logout') }}">
        @csrf
        <button type="submit">{{trans('front.profile.logout')}}</button>
    </form>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/intlTelInput.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const input = document.querySelector("#phone");
        const fullPhoneInput = document.querySelector("#full_phone");
        const iti = window.intlTelInput(input, {
            loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
        });

        document.getElementById('profile-form').addEventListener('submit', function (e) {
            fullPhoneInput.value = iti.getNumber();
        });

        document.getElementById('avatar-input').addEventListener('change', function (e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('avatar-preview').style.backgroundImage = `url('${URL.createObjectURL(file)}')`;
                document.getElementById('remove_avatar').value = '0';
                $('#remove-avatar-btn').toggleClass('disabled');
            }
        });
        document.getElementById('remove-avatar-btn').addEventListener('click', function () {
            document.getElementById('avatar-preview').style.backgroundImage = `url('{{ asset('images/site/profile/acc_preview.svg') }}')`;
            document.getElementById('avatar-input').value = '';
            document.getElementById('remove_avatar').value = '1';
            $('#remove-avatar-btn').toggleClass('disabled');
        });

        // AJAX pagination for orders
        document.getElementById('load-more-orders').addEventListener('click', function () {
            const btn = this;
            let currentPage = parseInt(btn.getAttribute('data-current-page'));
            const maxPages = parseInt(btn.getAttribute('data-max-pages'));
            if (currentPage >= maxPages) return;
            btn.disabled = true;
            $.get(`/profile?page=${currentPage + 1}`, function(html) {
                document.querySelector('.orders_list').insertAdjacentHTML('beforeend', html);
                currentPage++;
                btn.setAttribute('data-current-page', currentPage);
                if (currentPage >= maxPages) {
                    btn.style.display = 'none';
                }
                btn.disabled = false;
            });
        });
    </script>
@endsection
