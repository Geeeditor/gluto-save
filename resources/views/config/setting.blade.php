<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <title> App Config | Gluto HEP </title>
</head>
<body class="bg-gray-200">

    <form method="post" action="{{ route('platform.config.save') }}" class="bg-white shadow shadow-gray-300 mx-auto my-10 px-10 py-16 rounded-md w-[70%]" enctype="multipart/form-data">
        @csrf
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

            <h2 class="font-bold text-base md:text-2xl uppercase"> <a href="{{ url()->previous() }}"> <span class="mdi-arrow-left-circle mdi"></span></a> Application Configuration</h2>

            <!-- Application Name -->
            <div>
                <label for="app_name" class="block font-medium text-gray-700 text-sm">Application Name</label>
                <input type="text" id="app_name" name="appSetting[app_name]" value="{{ old('appSetting.app_name') }}" placeholder="Enter application name" required
                    class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
            </div>

            <!-- Application Description -->
            <div>
                <label for="app_description" class="block font-medium text-gray-700 text-sm">Application Description</label>
                <textarea id="app_description" name="appSetting[app_description]" placeholder="Enter application description" rows="3" required
                    class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">{{ old('appSetting.app_description') }}</textarea>
            </div>

            <!-- Application Logo -->
            <div>
                <label for="app_logo" class="block font-medium text-gray-700 text-sm">Application Logo</label>
                <input type="file" id="app_logo" name="appSetting[app_logo]" accept="image/*"
                    class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
            </div>

            <!-- Application Favicon -->
            <div>
                <label for="app_favicon" class="block font-medium text-gray-700 text-sm">Application Favicon <span class="text-[10px] text-gray-500">(recomended image dimension 50px x 50px)</span></label>
                <input type="file" id="app_favicon" name="appSetting[app_favicon]" accept="image/*"
                    class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
            </div>

            <!-- Application Email -->
            <div>
                <label for="app_email" class="block font-medium text-gray-700 text-sm">Application Email</label>
                <input type="email" id="app_email" name="appSetting[app_email]" value="{{ old('appSetting.app_email') }}" placeholder="Enter application email" required
                    class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
            </div>

            <!-- Support Email -->
            <div>
                <label for="support_email" class="block font-medium text-gray-700 text-sm">Support Email</label>
                <input type="email" id="support_email" name="appSetting[support_email]" value="{{ old('appSetting.support_email') }}" placeholder="Enter support email" required
                    class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
            </div>

            <!-- Application Phone -->
            <div>
                <label for="app_phone" class="block font-medium text-gray-700 text-sm">Application Phone</label>
                <input type="tel" id="app_phone" name="appSetting[app_phone]" value="{{ old('appSetting.app_phone') }}" placeholder="Enter application phone" required
                    class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
            </div>

            <!-- Withdrawal Enabled -->
            <div>
                <label for="withdrawal_enabled" class="flex items-center">
                    <input type="checkbox" id="withdrawal_enabled" name="appSetting[withdrawal_enabled]" value="1" {{ old('appSetting.withdrawal_enabled') ? 'checked' : '' }}
                        class="border-gray-300 rounded focus:ring-indigo-500 w-4 h-4 text-indigo-600">
                    <span class="ml-2 text-gray-700 text-sm">Enable Withdrawal</span>
                </label>
            </div>

            <!-- Contribution Enabled -->
            <div>
                <label for="contribution_enabled" class="flex items-center">
                    <input type="checkbox" id="contribution_enabled" name="appSetting[contribution_enabled]" value="1" {{ old('appSetting.contribution_enabled') ? 'checked' : '' }}
                        class="border-gray-300 rounded focus:ring-indigo-500 w-4 h-4 text-indigo-600">
                    <span class="ml-2 text-gray-700 text-sm">Enable Contribution</span>
                </label>
            </div>

            <!-- Subscription Enabled -->
            <div>
                <label for="subscription_enabled" class="flex items-center">
                    <input type="checkbox" id="subscription_enabled" name="appSetting[subscription_enabled]" value="1" {{ old('appSetting.subscription_enabled') ? 'checked' : '' }}
                        class="border-gray-300 rounded focus:ring-indigo-500 w-4 h-4 text-indigo-600">
                    <span class="ml-2 text-gray-700 text-sm">Enable Subscription</span>
                </label>
            </div>

            <!-- Application Address -->
            <div>
                <label for="app_address" class="block font-medium text-gray-700 text-sm">Application Address</label>
                <input type="text" id="app_address" name="appSetting[app_address]" value="{{ old('appSetting.app_address') }}" placeholder="Enter application address"
                    class="block shadow-sm mt-1 p-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:ring-indigo-500 w-full">
            </div>

            <!-- Social Links -->
            <div>
                <label class="block font-medium text-gray-700 text-sm">Social Links</label>
                <div class="space-y-4">
                    <input type="text" name="appSetting[app_social_links][whatsapp]" value="{{ old('appSetting.app_social_links.whatsapp') }}" placeholder="WhatsApp Link"
                        class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                    <input type="text" name="appSetting[app_social_links][twitter]" value="{{ old('appSetting.app_social_links.twitter') }}" placeholder="Twitter Link"
                        class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                    <input type="text" name="appSetting[app_social_links][instagram]" value="{{ old('appSetting.app_social_links.instagram') }}" placeholder="Instagram Link"
                        class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                    <input type="text" name="appSetting[app_social_links][facebook]" value="{{ old('appSetting.app_social_links.facebook') }}" placeholder="Facebook Link"
                        class="block shadow-sm mt-1 p-2 border border-gray-300 rounded-md w-full">
                </div>
            </div>

            <button class="bg-green-700 hover:bg-green-800 py-5 rounded-md w-full font-semibold text-white text-center">
                SAVE
            </button>

        </div>
    </form>


</body>
</html>
