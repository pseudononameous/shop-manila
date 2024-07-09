
<div style="display: none;" class="block">
    <div>
        <h3>
            <a href="{{route('item_category_page', 'men')}}">
                Shop Men's
            </a>
        </h3>
        <ul>
            @foreach($menCategory as $c)
                <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
            @endforeach
        </ul>
    </div>

    <div>
        <h3>
            <a href="{{route('item_category_page', 'women')}}">
                Shop Women's
            </a>
        </h3>
        <ul>
            @foreach($womenCategory as $c)
                <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
            @endforeach
        </ul>
    </div>

    <div>
        <h3>
            <a href="{{route('item_category_page', 'kids')}}">
                Shop Kids'
            </a>
        </h3>
        <ul>
            @foreach($kidsCategory as $c)
                <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
            @endforeach
        </ul>
    </div>

</div>

    


    @if(Request::url() != url('/')) 
    <!-- Mobile Category Nav -->
    <div class="mobile-block">
        <select class="form-control mobile-cat" name="forma" onchange="location = this.options[this.selectedIndex].value;">
            <option disabled selected>Men's</option>
            <option value="Sub category">Sub Category</option>
        </select>
    </div>
    @endif