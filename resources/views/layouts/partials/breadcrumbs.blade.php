


  <!-- Content Header (Page header) -->
  <div class="content-header mb-2">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Custom title</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            @php $segments = ''; @endphp
            @foreach(Request::segments() as $segment)
                @php
                    $slug = str_replace('_',' ',$segment);
                    $segments .= '/'.$segment; @endphp
                <li class="breadcrumb-item">
                    <a href="{{ $segments }}">{{ ucfirst($slug) }}</a>
                </li>
            @endforeach
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->