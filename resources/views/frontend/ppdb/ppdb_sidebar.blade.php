
<div class="bg-navy-blue text-white rounded-lg shadow-md p-6 h-full">
    <ul class="space-y-4 text-lg font-semibold">
        <li>
            <a href="{{ route('ppdb.index') }}" class="flex items-center p-3 rounded-md hover:bg-royal-blue transition duration-300
                {{ Request::routeIs('ppdb.index') ? 'bg-royal-blue' : '' }}">
                <i class="fas fa-home mr-3"></i> Portal PPDB
            </a>
        </li>
        <li>
            <a href="{{ route('ppdb.form') }}" class="flex items-center p-3 rounded-md hover:bg-royal-blue transition duration-300
                {{ Request::routeIs('ppdb.form') || Request::routeIs('ppdb.submit_form') ? 'bg-royal-blue' : '' }}">
                <i class="fas fa-edit mr-3"></i> Formulir PPDB
            </a>
        </li>
        <li>
            <a href="{{ route('ppdb.results') }}" class="flex items-center p-3 rounded-md hover:bg-royal-blue transition duration-300
                {{ Request::routeIs('ppdb.results') || Request::routeIs('ppdb.check_results') ? 'bg-royal-blue' : '' }}">
                <i class="fas fa-clipboard-check mr-3"></i> Hasil Seleksi
            </a>
        </li>
        <li>
            <a href="{{ route('ppdb.print_form') }}" class="flex items-center p-3 rounded-md hover:bg-royal-blue transition duration-300
                {{ Request::routeIs('ppdb.print_form') ? 'bg-royal-blue' : '' }}">
                <i class="fas fa-print mr-3"></i> Cetak Formulir
            </a>
        </li>
        <li>
            <a href="{{ route('ppdb.download') }}" class="flex items-center p-3 rounded-md hover:bg-royal-blue transition duration-300
                {{ Request::routeIs('ppdb.download') ? 'bg-royal-blue' : '' }}">
                <i class="fas fa-download mr-3"></i> Download Formulir
            </a>
        </li>
    </ul>
</div>