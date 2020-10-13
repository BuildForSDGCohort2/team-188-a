@extends('layouts.app', ['activePage' => 'notifications', 'titlePage' => __('Table List')])

@section('content')


<div class="content">

  <div class="container-fluid">
    <nav >

        <ul class="nav nav-pills">

          <li class="nav-item">
            <a class="nav-link " href="{{route('issues')}}">Issues</a>
          </li>
          <a class="nav-link active" style="background-color: blueviolet" href="#">Farmer Requests</a>
          
          </li>

          
         
        </ul>


      </nav>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title ">Pending Farmers Requests</h4>
            <p class="card-category"> Requests Subitted from Farmers</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" ">
                  <th>
                    ID
                  </th>
                  <th>
                    Service
                  </th>
                  <th>
                    Patient
                  </th>

                  <th>
                    Actions
                  </th>
                </thead>
                <tbody>

                @forelse ($requests as $request)
                <tr>
                  <td>
                    {{ucfirst($request->id)}}
                    </td>

                    <td>
                    @php
                        $services = explode('-',$request->service)
                    @endphp
                     {{in_array('ai',$services)?'Airtificial Isemination':''.
                        (in_array('ij',$services)?' Look into Injury ':'').
                        (in_array('chkup',$services)?'Checkup':'')
                        }}
                    </td>

                    <td>
                        {{' A '.$request->animal->gender.' '.ucfirst($request->animal->breed->breed).' '.$request->animal->species }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#professional_modal" @click="open_issue({{ $request->id }})">View info</button>
                    </td>
                </tr>
                @empty
                <tr>
                  <td>
                    <span class="text-primary"> No Requests</span>
                  </td>
                  <td>
                    <span class="text-primary"> No Requests</span>
                  </td>
                  <td>
                    <span class="text-primary"> No Requests</span>
                  </td>
                  <td>
                    <span class="text-primary"> No Requests</span>
                  </td>
                  <td>
                    <span class="text-primary"> No Requests</span>
                  </td>
                </tr>
                @endforelse
                </tbody>
              </table>

              {{-- {{ $issues->links() }} --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="professional_modal" class="modal fade" role="dialog" style="margin-top: 10%">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="color: black"> Issue <span style="color: rgb(255, 179, 0)">@{{ issues_show.identifier }}</span></h4>
          {{-- <small  class="form-text text-muted">Successful Applicants will Recieve confirmatory email</small> --}}

        </div>
        <div class="modal-body">
            <ul class="list-group">
                <li class="list-group-item"><b>Reason:</b> <span style="margin-left: 30px">@{{ issues_show.reason }}</span></li>
                <li class="list-group-item"><b>Information:</b> <span style="margin-left: 30px">@{{ issues_show.information }}</span></li>
              </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-outline-info" @click="save_item('isue/' + issues_show.id + '/read')">Mark as read</button>
      </div>

    </div>
  </div>
</div>
@endsection