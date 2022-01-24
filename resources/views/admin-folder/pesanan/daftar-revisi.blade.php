@if ($model->tahap == 'Tahap 1')
    <ul>
        @foreach ($daftarRevisi1 as $item)
            @if ($item->id_pesanan == $model->id)
                <li>{{ $item->revisi }} | {{ $item->status_revisi }}   @if ($item->status_revisi != 'Selesai')
                    | <a href="{{ route('user.done-revisi', $item->id) }}"
                        class="text-primary">Selesai</a>
                @endif</li>
            @endif
        @endforeach
    </ul>
@elseif ($model->tahap == 'Tahap 2')
    <ul>
        @foreach ($daftarRevisi2 as $item)
            @if ($item->id_pesanan == $model->id)
                <li>{{ $item->revisi }} | {{ $item->status_revisi }}  @if ($item->status_revisi != 'Selesai')
                    | <a href="{{ route('user.done-revisi', $item->id) }}"
                        class="text-primary">Selesai</a>
                @endif</li>
            @endif
        @endforeach
    </ul>
@endif
