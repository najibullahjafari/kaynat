@props(['striped' => false])

<div class="overflow-x-auto rounded-lg shadow border border-gray-200">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>
        <thead class="bg-gray-50">
            <tr>
                {{ $head }}
            </tr>
        </thead>
        <tbody
            class="bg-white divide-y divide-gray-200 @if($striped) odd:bg-white even:bg-gray-50 @endif">
            {{ $body }}
        </tbody>
    </table>
</div>