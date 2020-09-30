 @extends('layouts.app')

 @section('content')

 <div class="container">
     <div class="row justify-content-center">
         <div class="col-md-10">
             <div class="card">
                 <div class="card-body">
                     <form action="/seller/edit/{id}" method="POST">
                         @csrf
                         <table>
                             <tr>
                                 <input type="hidden" name="id" value="{{ $form->id }}">
                             </tr>
                             <tr>
                                 <th>yahoo_id: </th>
                                 <td><input type="text" name="yahoo_id" value="{{ $form->yahoo_id }}"></td>
                             </tr>
                             <tr>
                                 <td><input type="submit" value="決定する"></td>
                             </tr>
                         </table>
                     </form>

                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection