@php
    $statePath = $getStatePath();
    $base = $statePath ? $statePath.'.exames' : 'data.exames';
@endphp

<div class="gestar-exames-content">
    <table class="gestar-exames-table">
        <thead>
            <tr>
                <th>Exame</th>
                <th>1º Trimestre</th>
                <th>2º Trimestre</th>
                <th>3º Trimestre</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($exames as $key => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td>
                        <input
                            type="checkbox"
                            wire:model.live="{{ $base }}.{{ $key }}.t1"
                            class="fi-checkbox-input"
                            aria-label="{{ $label }} 1º trimestre"
                        />
                    </td>
                    <td>
                        <input
                            type="checkbox"
                            wire:model.live="{{ $base }}.{{ $key }}.t2"
                            class="fi-checkbox-input"
                            aria-label="{{ $label }} 2º trimestre"
                        />
                    </td>
                    <td>
                        <input
                            type="checkbox"
                            wire:model.live="{{ $base }}.{{ $key }}.t3"
                            class="fi-checkbox-input"
                            aria-label="{{ $label }} 3º trimestre"
                        />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
