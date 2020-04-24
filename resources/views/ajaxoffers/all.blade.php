@extends('layouts.app')

@section('content')

    <div class="alert alert-success" id="success_msg" style="display: none;">
        تم الحفظ بنجاح
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('messages.Offer Name')}}</th>
            <th scope="col">{{__('messages.Offer Price')}}</th>
            <th scope="col">{{__('messages.Offer details')}}</th>
            <th scope="col">صوره العرض</th>

            <th scope="col">{{__('messages.operation')}}</th>
        </tr>
        </thead>
        <tbody>


        @foreach($offers as $offer)
            <tr class="offerRow{{$offer -> id}}">
                <th scope="row">{{$offer -> id}}</th>
                <td>{{$offer -> name}}</td>
                <td>{{$offer -> price}}</td>
                <td>{{$offer -> details}}</td>
                <td><img  style="width: 90px; height: 90px;" src="{{asset('images/offers/'.$offer->photo)}}"></td>

                <td>
                    <a href="{{url('offers/edit/'.$offer -> id)}}" class="btn btn-success"> {{__('messages.update')}}</a>
                    <a href="{{route('offers.delete',$offer -> id)}}" class="btn btn-danger"> {{__('messages.delete')}}</a>

                    <a href="" offer_id="{{$offer -> id}}"  class="delete_btn btn btn-danger"> حذف اجاكس     </a>
                    <a href="{{route('ajax.offers.edit',$offer -> id)}}" class="btn btn-success"> تعديل</a>
                </td>

            </tr>
        @endforeach

        </tbody>



    </table>

@stop



@section('scripts')
    <script>

        $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();

              var offer_id =  $(this).attr('offer_id');

            $.ajax({
                type: 'post',
                 url: "{{route('ajax.offers.delete')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'id' :offer_id
                },
                success: function (data) {

                    if(data.status == true){
                        $('#success_msg').show();
                    }
                    $('.offerRow'+data.id).remove();
                }, error: function (reject) {

                }
            });
        });


    </script>
@stop
