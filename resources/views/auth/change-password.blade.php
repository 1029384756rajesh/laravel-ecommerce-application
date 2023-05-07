@extends("base")

@section("content")
    <div class="container my-4 px-3">
        <form class="card mx-auto max-w-lg" action="/account/password/change" method="post">
            @csrf
            @method("patch")

            <div class="card-header card-header-title">Change Password</div>

            <div class="card-body">
                <div class="form-group">
                    <label for="oldPassword" class="form-label">Old Password</label>
                    
                    <input type="password" id="oldPassword" class="form-control {{ $errors->has("old_password") ? "form-control-error" : "" }}" name="old_password" id="old_password">
                    
                    @error("old_password")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="newPassword" class="form-label">New Password</label>
                    
                    <input type="password" id="newPassword" class="form-control {{ $errors->has("old_password") ? "form-control-error" : "" }}" name="new_password">
                    
                    @error("new_password")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="newPasswordConfirmation" class="form-label">Confirm New Password</label>
                    
                    <input type="password" id="newPasswordConfirmation" class="form-control {{ $errors->has("new_password_confirmation") ? "form-control-error" : "" }}" name="new_password_confirmation">
                    
                    @error("new_password_confirmation")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary w-full">Change Password</button>
            </div>
        </form>
    </div>
@endsection