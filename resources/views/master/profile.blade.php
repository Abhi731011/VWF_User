@extends('master.main')

@section('content')
    <div class="row gy-4">
        <div class="col-lg-4">
            <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                <img src="{{ auth()->user()->banner_img ? asset(auth()->user()->banner_img) : asset('assets/images/user-grid/user-grid-bg1.png') }}"
                    alt="Banner Image" class="w-100 object-fit-cover">
                <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <img src="{{ auth()->user()->profile_img ? asset(auth()->user()->profile_img) : asset('assets/images/user-grid/user-grid-img14.png') }}"
                            alt="Profile Image"
                            class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                        <h6 class="mb-0 mt-16">{{ auth()->user()->name }}</h6>
                        <span class="text-secondary-light mb-16">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="mt-24">
                        <h6 class="text-xl mb-16">Personal Info</h6>
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Full Name:</span>
                                <span>{{ auth()->user()->name }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Email:</span>
                                <span>{{ auth()->user()->email }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Phone:</span>
                                <span>{{ auth()->user()->phone }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Address:</span>
                                <span>{{ auth()->user()->address }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">City:</span>
                                <span>{{ auth()->user()->city }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">State:</span>
                                <span>{{ auth()->user()->state }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Country:</span>
                                <span>{{ auth()->user()->country }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Zip Code:</span>
                                <span>{{ auth()->user()->zip_code }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body p-24">
                    <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24 active" id="pills-edit-profile-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab"
                                aria-controls="pills-edit-profile" aria-selected="true">
                                Edit Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-change-passwork-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-change-passwork" type="button" role="tab"
                                aria-controls="pills-change-passwork" aria-selected="false" tabindex="-1">
                                Change Password
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-notification-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-notification" type="button" role="tab"
                                aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                Notification Settings
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel"
                            aria-labelledby="pills-edit-profile-tab" tabindex="0">
                            <h6 class="text-md text-primary-light mb-16">Profile Image</h6>
                      <!-- Upload Image Start -->
<div class="mb-24 mt-16">
    <div class="avatar-upload d-flex flex-column align-items-center justify-content-center position-relative"
        style="min-height:220px;">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileImgForm" class="w-100">
            @csrf
            @method('PATCH')

            <div class="avatar-preview mb-2 position-relative d-flex justify-content-center">
                <div class="avatar-circle position-relative">
                    @php
                        $profileImg = auth()->user()->profile_img
                            ? asset(auth()->user()->profile_img)
                            : asset('assets/images/user-grid/user-grid-img14.png');
                    @endphp

                    <img src="{{ $profileImg }}" alt="Profile Image" id="profileImgTag"
                        class="object-fit-cover" />
                    
                    <!-- Camera button -->
                    <div class="avatar-edit position-absolute">
                        <input type="file" id="imageUpload" name="profile_img" accept=".png, .jpg, .jpeg" style="display:none;">
                        <label for="imageUpload"
                            class="w-40-px h-40-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle shadow"
                            style="cursor:pointer;">
                            <iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Circle container */
    .avatar-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #fff;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Camera button inside circle */
    .avatar-edit {
        bottom: 10px;
        right: 10px;
    }

    .avatar-upload .avatar-preview img {
        transition: box-shadow 0.2s, border 0.2s;
    }

    .avatar-upload .avatar-edit label:hover {
        background: #e0e7ff;
        border-color: #6366f1;
        color: #6366f1;
    }

    @media (max-width: 576px) {
        .avatar-circle {
            width: 120px !important;
            height: 120px !important;
        }

        .avatar-upload .avatar-edit label {
            width: 32px !important;
            height: 32px !important;
        }
    }
</style>

                            <script>
                                document.getElementById('imageUpload').addEventListener('change', function(e) {
                                    const [file] = e.target.files;
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            document.getElementById('profileImgTag').src = e.target.result;
                                        }
                                        reader.readAsDataURL(file);
                                        // Auto-submit form after image selection
                                        document.getElementById('profileImgForm').submit();
                                    }
                                });
                            </script>
                            <!-- Upload Image End -->
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="name"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name
                                                <span class="text-danger-600">*</span></label>
                                            <input type="text" name="name" class="form-control radius-8"
                                                id="name" value="{{ old('name', auth()->user()->name) }}"
                                                placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="email"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span
                                                    class="text-danger-600">*</span></label>
                                            <input type="email" name="email" class="form-control radius-8"
                                                id="email" value="{{ old('email', auth()->user()->email) }}"
                                                placeholder="Enter email address">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="phone"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Phone <span
                                                    class ="text-danger-600">*</span> </label>
                                            <input type="text" name="phone" class="form-control radius-8"
                                                id="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                                placeholder="Enter phone number">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="address"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Address
                                            </label>
                                            <input type="text" name="address" class="form-control radius-8"
                                                id="address" value="{{ old('address', auth()->user()->address) }}"
                                                placeholder="Enter Address">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="city"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">City
                                            </label>
                                            <input type="text" name="city" class="form-control radius-8"
                                                id="city" value="{{ old('city', auth()->user()->city) }}"
                                                placeholder="Enter City">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="state"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">State
                                            </label>
                                            <input type="text" name="state" class="form-control radius-8"
                                                id="state" value="{{ old('state', auth()->user()->state) }}"
                                                placeholder="Enter State">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="country"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Country</label>
                                            <input type="text" name="country" class="form-control radius-8"
                                                id="country" value="{{ old('country', auth()->user()->country) }}"
                                                placeholder="Enter Country">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="zip_code"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Zip
                                                Code</label>
                                            <input type="text" name="zip_code" class="form-control radius-8"
                                                id="zip_code" value="{{ old('zip_code', auth()->user()->zip_code) }}"
                                                placeholder="Enter Zip Code">
                                        </div>
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="banner_img"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Banner
                                                Image</label>
                                            <input type="file" name="banner_img" class="form-control radius-8"
                                                id="banner_img" accept=".png, .jpg, .jpeg">
                                            @if (auth()->user()->banner_img)
                                                <img src="{{ asset(auth()->user()->banner_img) }}" alt="Banner Image"
                                                    style="max-width: 120px; max-height: 60px; margin-top: 10px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <button type="reset"
                                        class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="pills-change-passwork" role="tabpanel"
                            aria-labelledby="pills-change-passwork-tab" tabindex="0">
                            <form action="{{ route('password.update') }}" method="POST" id="changePasswordForm">
                                @csrf
                                @method('PUT')
                                <div class="mb-20">
                                    <label for="your-password"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">New Password <span
                                            class="text-danger-600">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control radius-8" id="your-password" name="password"
                                            placeholder="Enter New Password*" required>
                                        <span
                                            class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                            data-toggle="#your-password"></span>
                                    </div>
                                </div>
                                <div class="mb-20">
                                    <label for="confirm-password"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Confirmed Password <span
                                            class="text-danger-600">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control radius-8" id="confirm-password" name="password_confirmation"
                                            placeholder="Confirm Password*" required>
                                        <span
                                            class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                            data-toggle="#confirm-password"></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">Cancel</button>
                                    <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">Update</button>
                                </div>
                            </form>
                            <script>
                                document.querySelectorAll('.toggle-password').forEach(function(eye) {
                                    eye.addEventListener('click', function() {
                                        var input = document.querySelector(this.getAttribute('data-toggle'));
                                        if (input.type === 'password') {
                                            input.type = 'text';
                                            this.classList.remove('ri-eye-line');
                                            this.classList.add('ri-eye-off-line');
                                        } else {
                                            input.type = 'password';
                                            this.classList.remove('ri-eye-off-line');
                                            this.classList.add('ri-eye-line');
                                        }
                                    });
                                });
                            </script>
                        </div>

                        <div class="tab-pane fade" id="pills-notification" role="tabpanel"
                            aria-labelledby="pills-notification-tab" tabindex="0">
                            <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                <label for="companzNew" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                <div class="d-flex align-items-center gap-3 justify-content-between">
                                    <span class="form-check-label line-height-1 fw-medium text-secondary-light">Company
                                        News</span>
                                    <input class="form-check-input" type="checkbox" role="switch" id="companzNew">
                                </div>
                            </div>
                            <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                <label for="pushNotifcation" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                <div class="d-flex align-items-center gap-3 justify-content-between">
                                    <span class="form-check-label line-height-1 fw-medium text-secondary-light">Push
                                        Notification</span>
                                    <input class="form-check-input" type="checkbox" role="switch" id="pushNotifcation"
                                        checked>
                                </div>
                            </div>
                            <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                <label for="weeklyLetters" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                <div class="d-flex align-items-center gap-3 justify-content-between">
                                    <span class="form-check-label line-height-1 fw-medium text-secondary-light">Weekly News
                                        Letters</span>
                                    <input class="form-check-input" type="checkbox" role="switch" id="weeklyLetters"
                                        checked>
                                </div>
                            </div>
                            <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                <label for="meetUp" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                <div class="d-flex align-items-center gap-3 justify-content-between">
                                    <span class="form-check-label line-height-1 fw-medium text-secondary-light">Meetups
                                        Near you</span>
                                    <input class="form-check-input" type="checkbox" role="switch" id="meetUp">
                                </div>
                            </div>
                            <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                <label for="orderNotification"
                                    class="position-absolute w-100 h-100 start-0 top-0"></label>
                                <div class="d-flex align-items-center gap-3 justify-content-between">
                                    <span class="form-check-label line-height-1 fw-medium text-secondary-light">Orders
                                        Notifications</span>
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="orderNotification" checked>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        @if (session('success'))
            <div style="display:none" id="debug-session-success">{{ session('success') }}</div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                });
            </script>
        @endif
    @endpush
@endsection
