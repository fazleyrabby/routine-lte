


  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-left">
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