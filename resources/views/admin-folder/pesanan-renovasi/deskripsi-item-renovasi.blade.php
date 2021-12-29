@if (session('role') == 'Admin')
    <ul >
        @foreach ($model->deskripsi_item as $item)
            <li>{{$item['nama_item']}} (luas : {{$item['luas_bangunan']}} m2 | harga: {{$item['harga_item']}})</li>
        @endforeach
    </ul>  
@else
    <ul >
        @foreach ($model->deskripsi_item as $item)
            <li>{{$item['nama_item']}} (luas : {{$item['luas_bangunan']}} m2)</li>
        @endforeach
    </ul>  
@endif