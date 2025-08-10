@extends('platform::admin')
@section('content')
<div>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- {{dd($paymentData)}} --}}
   @if (empty($paymentData))
       No Payment Found
   @else
       {{-- {{count($paymentData)}} --}}
       <div class="flex justify-between items-center mt-1 mb-3 pl-3 w-full">
        <div>
            <h3 class="font-semibold text-slate-800 text-lg">User Payments</h3>
            <p class="text-slate-500">All user payments can be found here (registeration, contribution, debt payment and subscription).</p>
        </div>
        {{-- Search --}}
        @livewire('search-bar')
    </div>

    <div class="relative flex flex-col bg-white bg-clip-border shadow-md rounded-lg w-full h-full overflow-scroll text-gray-700">
      <table class="w-full min-w-max text-left table-auto">
        <thead>
          <tr>
            <th class="bg-slate-50 p-4 border-slate-300 border-b">
              <p class="block font-normal text-slate-500 text-sm leading-none">
                ID
              </p>
            </th>
            <th class="bg-slate-50 p-4 border-slate-300 border-b">
              <p class="block font-normal text-slate-500 text-sm leading-none">
                Customer
              </p>
            </th>
            <th class="bg-slate-50 p-4 border-slate-300 border-b">
              <p class="block font-normal text-slate-500 text-sm leading-none">
                Amount
              </p>
            </th>
            <th class="bg-slate-50 p-4 border-slate-300 border-b">
              <p class="block font-normal text-slate-500 text-sm leading-none">
                Trx Ref
              </p>
            </th>
            <th class="bg-slate-50 p-4 border-slate-300 border-b">
              <p class="block font-normal text-slate-500 text-sm leading-none">
                Payment Method
              </p>
            </th>

            <th class="bg-slate-50 p-4 border-slate-300 border-b">
              <p class="block font-normal text-slate-500 text-sm leading-none">
                Payment Type
              </p>
            </th>
            <th class="bg-slate-50 p-4 border-slate-300 border-b">
              <p class="block font-normal text-slate-500 text-sm leading-none">
                Payment Date
              </p>
            </th>
            <th class="bg-slate-50 p-4 border-slate-300 border-b">
              <p class="block font-normal text-slate-500 text-sm leading-none">
                Payment Status
              </p>
            </th>
            <th class="bg-slate-50 p-4 border-slate-300 border-b">
                <p class="block font-normal text-slate-500 text-sm leading-none">
                  Payment Proof
                </p>
              </th>
            <th class="bg-slate-50 p-4 border-slate-300 border-b">
              <p class="block font-normal text-slate-500 text-sm leading-none">
                Action
              </p>
            </th>
          </tr>
        </thead>
        <tbody>
        @foreach ($paymentData as $payment )
        <tr class="hover:bg-slate-50">
            <td class="p-4 py-5 border-slate-200 border-b">
              <p class="block font-semibold text-slate-800 text-sm">{{ $payment['id'] }}</p>
            </td>
            <td class="p-4 py-5 border-slate-200 border-b">
              <p class="text-slate-500 text-sm">{{$payment['name']}}</p>
            </td>
            <td class="p-4 py-5 border-slate-200 border-b">
              <p class="text-slate-500 text-sm">NGN {{ number_format($payment['amount'])}}</p>
            </td>
            <td class="p-4 py-5 border-slate-200 border-b">
              <p class="text-slate-500 text-sm">{{$payment['transaction_reference']}}</p>
            </td>
            <td class="p-4 py-5 border-slate-200 border-b">
              <p class="text-slate-500 text-sm">{{ $payment['payment_method'] == 'gluto_transfer' ? 'Bank Transfer' : ($payment['payment_method'] == 'wallet_balance' ? 'Wallet Balance' : ($payment['payment_method'] == 'paystack' ? 'Paystack' : 'Unknown')) }}</p>
            </td>

            <td class="p-4 py-5 border-slate-200 border-b">
                <p class="text-slate-500 text-sm">{{$payment['payment_type']}}</p>
              </td>
              <td class="p-4 py-5 border-slate-200 border-b">
                  <p class="text-slate-500 text-sm">{{$payment['created_at']->format('F j, Y')}}</p>
                </td>
            <td class="p-4 py-5 border-slate-200 border-b">
                <p class="text-slate-500 text-sm">{{$payment['payment_status']}}</p>
              </td>
              <td class="p-4 py-5 border-slate-200 border-b">
                <p class="text-slate-500 text-sm">
                      @if ($payment['payment_proof'] !== null)
                          <a href="{{ asset('images/payments/' . basename($payment['payment_proof'])) }}" target="_blank" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200">
                              open <span class="mdi mdi-open-in-new"></span>
                          </a>
                      @else
                          <a href="javascript:void(0)" target="_blank" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200">
                              N/A <span class="mdi mdi-cancel"></span>
                          </a>
                      @endif

                  </p>
              </td>
            <td class="p-4 py-5 border-slate-200 border-b">
                <p class="text-slate-500 text-sm">
                    <a class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md w-fit font-medium text-white text-sm transition duration-200" href="{{ route('platform.payments.update', ['id' => $payment['payment_id']]) }}">
                        view more <span class="mdi mdi-open-in-new"></span>
                    </a>
                </p>
            </td>
          </tr>
        @endforeach


        </tbody>
      </table>
    </div>
   @endif
</div>
@endsection

