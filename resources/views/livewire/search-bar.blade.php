<div id="search-bar" class="ml-3">
    <div class="relative w-full min-w-[200px] max-w-sm">
    <form role="search" class="relative">
        <input wire:model.live.debounce.500ms="trx"
        class="bg-transparent bg-white shadow-sm focus:shadow-md py-2 pr-11 pl-3 border border-slate-200 hover:border-slate-400 focus:border-slate-400 rounded focus:outline-none w-full h-10 text-slate-700 placeholder:text-slate-400 text-sm transition duration-300 ease"
        placeholder="Search for invoice..."
        />
        <button
        class="top-1 right-1 absolute flex items-center bg-white my-auto px-2 rounded w-8 h-8"
        type="button"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
        </button>
    </form>
    @if (sizeof($results) > 0)
      <div class="top-0 absolute">
            @foreach ($results as $tr)
                <p>{{$tr->payment_method}}</p>
            @endforeach
        </div>
    @endif

    </div>
</div>
