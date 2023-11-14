<h1 class="mb-3">Featured products</h1>
<hr>


<div class="row">
    <div class="col">
        @include('includes.flash.error')
        @include('includes.flash.success')
        @include('includes.flash.invalid')
    </div>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Price (best)</th>
        <th>Type</th>
        <th>Vendor</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <form action="{{route('admin.featuredproducts.remove')}}" method="post">
        {{csrf_field()}}

        @if($products->count() == 0 )
            <tr>
                <td colspan="6" class="text-center">
                    <h4 class="mt-5">No products found</h4>
                </td>
            </tr>
        @else
            @foreach($products as $product)
                <tr>
                    <td>
                        <strong>{{$product->name}}</strong>
                    </td>
                    <td>
                        {{$product->category->name}}
                    </td>
                    <td>
                        @include('includes.currency', ['usdValue' => $product->price_from])
                    </td>
                    <td>
                        <span class="badge badge-info">{{$product->type}}</span>
                    </td>
                    <td>
                        <a href="{{route('admin.users.view',['user'=>$product->user->id])}}">{{$product->user->username}}</a>
                    </td>
                    <td>
                        <a href="{{ route('admin.product.edit', $product -> id) }}" class="btn btn-outline-mblue">
                            <i class="fas fa-pen-square"></i>
                        </a>
                        <button type="submit" value="{{$product->id}}" name="product_id"
                                class="btn btn-outline-warning">
                            <i class="fas fa-backspace"></i> Remove from featured
                        </button>
                    </td>
                </tr>
            @endforeach

        @endif
    </form>

    </tbody>
</table>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="text-center">
            {{$products->links()}}
        </div>
    </div>
</div>
