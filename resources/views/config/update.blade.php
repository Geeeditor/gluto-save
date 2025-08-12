<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update App Configuration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <style>
        /* From Uiverse.io by lenin55 */
.cl-toggle-switch {
 position: relative;
}

.cl-switch {
 position: relative;
 display: inline-block;
}
/* Input */
.cl-switch > input {
 appearance: none;
 -moz-appearance: none;
 -webkit-appearance: none;
 z-index: -1;
 position: absolute;
 right: 6px;
 top: -8px;
 display: block;
 margin: 0;
 border-radius: 50%;
 width: 40px;
 height: 40px;
 background-color: rgb(0, 0, 0, 0.38);
 outline: none;
 opacity: 0;
 transform: scale(1);
 pointer-events: none;
 transition: opacity 0.3s 0.1s, transform 0.2s 0.1s;
}
/* Track */
.cl-switch > span::before {
 content: "";
 float: right;
 display: inline-block;
 margin: 5px 0 5px 10px;
 border-radius: 7px;
 width: 36px;
 height: 14px;
 background-color: rgb(0, 0, 0, 0.38);
 vertical-align: top;
 transition: background-color 0.2s, opacity 0.2s;
}
/* Thumb */
.cl-switch > span::after {
 content: "";
 position: absolute;
 top: 2px;
 right: 16px;
 border-radius: 50%;
 width: 20px;
 height: 20px;
 background-color: #fbf5f5;
 box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
 transition: background-color 0.2s, transform 0.2s;
}
/* Checked */
.cl-switch > input:checked {
 right: -10px;
 background-color: #8f8f8f;
}

.cl-switch > input:checked + span::before {
 background-color: #8f8f8f;
}

.cl-switch > input:checked + span::after {
 background-color: #fbf5f5;
 transform: translateX(16px);
}
/* Hover, Focus */
.cl-switch:hover > input {
 opacity: 0.04;
}

.cl-switch > input:focus {
 opacity: 0.12;
}

.cl-switch:hover > input:focus {
 opacity: 0.16;
}
/* Active */
.cl-switch > input:active {
 opacity: 1;
 transform: scale(0);
 transition: transform 0s, opacity 0s;
}

.cl-switch > input:active + span::before {
 background-color: #8f8f8f;
}

.cl-switch > input:checked:active + span::before {
 background-color: #8f8f8f;
}
/* Disabled */
.cl-switch > input:disabled {
 opacity: 0;
}

.cl-switch > input:disabled + span::before {
 background-color: #ddd;
}

.cl-switch > input:checked:disabled + span::before {
 background-color: #bfdbda;
}

.cl-switch > input:checked:disabled + span::after {
 background-color: #61b5b4;
}
    </style>
</head>
<body class="bg-gray-200">
    <div class="mx-auto container">
        {{-- <h1 class="mb-6 font-semibold text-2xl">Edit App Settings</h1> --}}

        <form method="post" action="{{ route('platform.config.update-config', ['id' => $appSettings->id]) }}" class="bg-white shadow shadow-gray-300 mx-auto my-10 px-10 py-16 rounded-md md:w-[70%]" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Use PUT method for updates -->

            <div class="space-y-6">
                @if ($errors->any())
                    <div class="bg-red-200 mb-4 p-4 rounded text-red-700">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('info'))
                <div class="bg-green-200 mb-4 p-4 rounded text-green-700">
                    <p>{{ session('info') }}</p>
                </div>
                @endif

                <h2 class="font-bold text-base md:text-2xl uppercase">
                    <a href="{{ url()->previous() }}">
                        <span class="mdi-arrow-left-circle mdi"></span>
                    </a>
                    Application Configuration
                </h2>

                <!-- Application Name -->
                <div>
                    <label for="app_name" class="block font-medium text-gray-700 text-sm">Application Name</label>
                    <input type="text" id="app_name" name="appSetting[app_name]" value="{{ old('appSetting.app_name', $appSettings->app_name) }}" placeholder="Enter application name" required
                        class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
                </div>

                <!-- Application Description -->
                <div>
                    <label for="app_description" class="block font-medium text-gray-700 text-sm">Application Description</label>
                    <textarea id="app_description" name="appSetting[app_description]" placeholder="Enter application description" rows="3" required
                        class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">{{ old('appSetting.app_description', $appSettings->app_description) }}</textarea>
                </div>

                <!-- Application Logo -->
                <div>
                    <label for="app_logo" class="block font-medium text-gray-700 text-sm">Application Logo</label>
                    <img class="w-[150px] h-[150px] object-contain" src="{{ asset('/images/config/' . $appSettings->app_logo) }}" alt="">
                    <input type="file" id="app_logo" name="appSetting[app_logo]" accept="image/*"
                        class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                </div>

                <!-- Application Favicon -->
                <div>
                    <label for="app_favicon" class="block font-medium text-gray-700 text-sm">Application Favicon <span class="text-[10px] text-gray-500">(recommended image dimension 50px x 50px)</span></label>
                    <img class="w-[50px] h-[50px] object-contain" src="{{ asset('/images/config/' . $appSettings->app_favicon) }}" alt="">

                    <input type="file" id="app_favicon" name="appSetting[app_favicon]" accept="image/*"
                        class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                </div>

                <!-- Application Email -->
                <div>
                    <label for="app_email" class="block font-medium text-gray-700 text-sm">Application Email</label>
                    <input type="email" id="app_email" name="appSetting[app_email]" value="{{ old('appSetting.app_email', $appSettings->app_email) }}" placeholder="Enter application email" required
                        class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
                </div>

                <!-- Support Email -->
                <div>
                    <label for="support_email" class="block font-medium text-gray-700 text-sm">Support Email</label>
                    <input type="email" id="support_email" name="appSetting[support_email]" value="{{ old('appSetting.support_email', $appSettings->support_email) }}" placeholder="Enter support email" required
                        class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
                </div>

                {{-- <!-- Application Phone -->
                <div>
                    <label for="app_phone" class="block font-medium text-gray-700 text-sm">Application Phone</label>
                    <input type="tel" id="app_phone" name="appSetting[app_phone]" value="{{ old('appSetting.app_phone', $appSettings->app_phone) }}" placeholder="Enter application phone" required
                        class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
                </div> --}}

                <!-- Application Phone -->
                <div>
                    <label for="app_phone" class="block font-medium text-gray-700 text-sm">Exchange Rate</label>
                    <input type="number" step="0.01" id="app_phone" name="appSetting[rate]" value="{{ old('appSetting.rate', $appSettings->rate) }}" placeholder="1590.00" required
                        class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
                </div>



                <div class="flex md:flex-row flex-col gap-2">
                    <!-- Withdrawal Enabled -->
                    <div class="flex items-center cl-toggle-switch">
                        <label class="cl-switch">
                            <input type="hidden" name="appSetting[withdrawal_enabled]" value="0"> <!-- Hidden input for false -->
                            <input type="checkbox" id="withdrawal_enabled" name="appSetting[withdrawal_enabled]" value="1" {{ old('appSetting.withdrawal_enabled', $appSettings->withdrawal_enabled) ? 'checked' : '' }}>
                            <span></span>
                        </label>
                        <span class="ml-2 text-gray-700 text-sm">Enable Withdrawal</span>
                    </div>

                    <!-- Contribution Enabled -->
                    <div class="flex items-center cl-toggle-switch">
                        <label class="cl-switch">
                            <input type="hidden" name="appSetting[contribution_enabled]" value="0"> <!-- Hidden input for false -->
                            <input type="checkbox" id="contribution_enabled" name="appSetting[contribution_enabled]" value="1" {{ old('appSetting.contribution_enabled', $appSettings->contribution_enabled) ? 'checked' : '' }}>
                            <span></span>
                        </label>
                        <span class="ml-2 text-gray-700 text-sm">Enable Contribution</span>
                    </div>

                    <!-- Subscription Enabled -->
                    <div class="flex items-center cl-toggle-switch">
                        <label class="cl-switch">
                            <input type="hidden" name="appSetting[subscription_enabled]" value="0"> <!-- Hidden input for false -->
                            <input type="checkbox" id="subscription_enabled" name="appSetting[subscription_enabled]" value="1" {{ old('appSetting.subscription_enabled', $appSettings->subscription_enabled) ? 'checked' : '' }}>
                            <span></span>
                        </label>
                        <span class="ml-2 text-gray-700 text-sm">Enable Subscription</span>
                    </div>

                    <!-- Topup Enabled -->
                    <div class="flex items-center cl-toggle-switch">
                        <label class="cl-switch">
                            <input type="hidden" name="appSetting[topup_enabled]" value="0"> <!-- Hidden input for false -->
                            <input type="checkbox" id="topup_enabled" name="appSetting[topup_enabled]" value="1" {{ old('appSetting.topup_enabled', $appSettings->topup_enabled) ? 'checked' : '' }}>
                            <span></span>
                        </label>
                        <span class="ml-2 text-gray-700 text-sm">Enable Wallet Funding</span>
                    </div>
                </div>

                <script>
                    document.querySelectorAll('.cl-switch input[type="checkbox"]').forEach(function(checkbox) {
                        checkbox.addEventListener('change', function() {
                            const isChecked = this.checked;
                            const value = isChecked ? true : false;

                            // Update the checkbox value (if needed)
                            console.log(`${this.name}: ${value}`); // You can replace this with your logic to handle the value
                        });
                    });
                </script>




                <!-- Application Address -->
                <div>
                    <label for="app_address" class="block font-medium text-gray-700 text-sm">Application Address</label>
                    <input type="text" id="app_address" name="appSetting[app_address]" value="{{ old('appSetting.app_address', $appSettings->app_address) }}" placeholder="Enter application address"
                        class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
                </div>

                <!-- Social Links -->
                <div>
                    <label class="block font-medium text-gray-700 text-sm">Social Links</label>
                    <div class="space-y-4">
                        <input type="text" name="appSetting[app_social_links][whatsapp]" value="{{ old('appSetting.app_social_links.whatsapp', $socialLinks['whatsapp'] ?? '') }}" placeholder="WhatsApp Link"
                            class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                        <input type="text" name="appSetting[app_social_links][twitter]" value="{{ old('appSetting.app_social_links.twitter', $socialLinks['twitter'] ?? '') }}" placeholder="Twitter Link"
                            class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                        <input type="text" name="appSetting[app_social_links][instagram]" value="{{ old('appSetting.app_social_links.instagram', $socialLinks['instagram'] ?? '') }}" placeholder="Instagram Link"
                            class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                        <input type="text" name="appSetting[app_social_links][facebook]" value="{{ old('appSetting.app_social_links.facebook', $socialLinks['facebook'] ?? '') }}" placeholder="Facebook Link"
                            class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                    </div>
                </div>

                <button class="bg-gray-700 hover:bg-gray-800 py-5 rounded-md w-full font-semibold text-white text-center">
                    Save Configuration
                </button>

            </div>
        </form>
</body>
</html>
