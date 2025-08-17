<button type="submit" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 border border-transparent
    rounded-md shadow-sm text-sm font-semibold text-white bg-primary hover:bg-primary/80 focus:outline-none focus:ring-2
    focus:ring-offset-2 focus:ring-primary']) }}>
    {{ $slot }}
</button>