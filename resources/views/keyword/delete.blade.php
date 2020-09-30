 @extends('layouts.app')

 @section('content')

 <div class="container">
     <div class="row justify-content-center">
         <div class="col-md-10">
             <div class="card">
                 <div class="card-body">

                     <form action="/keyword/delete/{id}" method="POST">
                         @csrf
                         <table>
                             <tr>
                                 <input type="hidden" name="id" value="{{ $form->id }}">
                             </tr>
                             <tr>
                                 <th>keyword: </th>
                                 <td><input type="text" name="keyword" value="{{ $form->keyword }}" 　readonly class="readonly"></td>
                             </tr>
                             <tr>
                                 <td><input type="submit" value="削除"></td>
                             </tr>
                         </table>
                     </form>

                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection