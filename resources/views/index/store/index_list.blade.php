@foreach($store as $key => $value)
    <a href="javascript:;" class="shop_list flex mb10">
        <div class="shop_logo">
            <img src="{{ '/' . $value->logo }}" alt="">
        </div>
        <div class="flex_1">
            <h3 class="oh1 fz16 c3 lh0">{{ $value->store_name }}</h3>
            <p class="fz12 c9">{{ date("Y-m-d",$value->create_time) }}</p>
        </div>
    </a>
@endforeach