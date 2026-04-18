<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-tumbas border border-transparent rounded-md font-extrabold text-xs text-white uppercase tracking-widest hover:bg-tumbas-dark focus:bg-tumbas-dark active:bg-tumbas-dark focus:outline-none focus:ring-2 focus:ring-tumbas-light focus:ring-offset-2 transition ease-in-out duration-150 shadow-md']) }}>
    {{ $slot }}
</button>
