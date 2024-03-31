@if (!isset($multiple) || !$multiple)    
    <div class="form-group">
        <label>{{readable($name)}}</label>
        <div class="rii-wrapper">
            @if (isset($file))
                <input type="hidden" name="{{$name}}[id]" value="{{$file->id}}">
            @endif
            <input type="file" name="{{$name}}[file]" class="rii-content-input d-none">
            <div class="row">
                <div class="col-4">
                    <div class="rii-box">
                        <img src="{{isset($file) ? $file->url : ''}}" class="{{isset($file) ? '' : 'd-none'}}">
                        <span class="{{isset($file) ? 'd-none' : ''}}">
                            <br>Drag files here,<br>or click to upload
                        </span>
                    </div>
                </div>
                <div class="col-8">
                    <table class="rii-inputs">
                        <tr>
                            <td>
                                <label for="">Name:</label>
                            </td>
                            <td>
                                <input type="text" class="rii-input form-control rii-filename" value="{{isset($file) ? $file->name : ''}}" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Alt:</label>
                            </td>
                            <td>
                                <input type="text" name="{{$name}}[alt]" class="rii-input form-control rii-filealt" value="{{isset($file) ? $file->alt : ''}}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Title:</label>
                            </td>
                            <td>
                                <input type="text" name="{{$name}}[title]" class="rii-input form-control rii-filetitle" value="{{isset($file) ? $file->title : ''}}">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <span data-input="{{$name}}.file" class="input-error"></span>
    </div>
@else
    TODO
@endif