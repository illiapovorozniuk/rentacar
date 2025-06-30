@extends('front.template')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/front/profile.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">
@endsection

@section('body')
    <div class="login_container">
        <form method="POST" action="{{ route('front.profile.update') }}" id="profile-form" enctype="multipart/form-data">
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
                <button type="button" id="remove-avatar-btn" style="margin-top: 10px;" class="{{$user->getFirstMediaUrl('avatar')?'':'disabled'}}">Remove Avatar</button>
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

            <button class="button_submit" type="submit">Update Profile</button>
            <a href="{{ route('front.profile.password') }}" class="profile_link">Change Password</a>
        </form>
    </div>
        <form method="POST" action="{{ route('front.logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/intlTelInput.min.js"></script>
    <script>
        const input = document.querySelector("#phone");
        const fullPhoneInput = document.querySelector("#full_phone");
        const iti = window.intlTelInput(input, {
            loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
        });

        document.getElementById('profile-form').addEventListener('submit', function(e) {
            fullPhoneInput.value = iti.getNumber();
        });

        document.getElementById('avatar-input').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('avatar-preview').style.backgroundImage = `url('${URL.createObjectURL(file)}')`;
                document.getElementById('remove_avatar').value = '0';
                $('#remove-avatar-btn').toggleClass('disabled');
            }
        });
        document.getElementById('remove-avatar-btn').addEventListener('click', function() {
            document.getElementById('avatar-preview').style.backgroundImage = `url('{{ asset('images/site/profile/acc_preview.svg') }}')`;
            document.getElementById('avatar-input').value = '';
            document.getElementById('remove_avatar').value = '1';
            $('#remove-avatar-btn').toggleClass('disabled');
        });
    </script>
@endsection
