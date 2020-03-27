<form action="{{ uri('admin/settings') }}" data-type="ajax">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="section" value="{{ $section }}">
    {{ csrf_field() }}

    @foreach ($data as $key => $setting)
        @if($setting['size'] != 'hidden')
            <div class="form-group">
                <label for="{{ $key }}">{{ $setting['description'] }}</label>
                @if($setting['size'] == 'input')
                    <input id="{{ $key }}" class="form-control" name="{{ $key }}" value="{{ $setting['value'] }}">
                @elseif($setting['size'] == 'textarea')
                    <textarea id="{{ $key }}" class="form-control" name="{{ $key }}">{{ $setting['value'] }}</textarea>
                @elseif($setting['size'] == 'boolean')
                    <select name="{{ $key }}" id="{{ $key }}" class="form-control">
                        <option {{ !$setting['value'] ? 'selected' : '' }} value="0">Нет</option>
                        <option {{ $setting['value'] ? 'selected' : '' }} value="1">Да</option>
                    </select>
                @elseif($setting['size'] == 'ckeditor')
                    <textarea id="{{ $key }}" class="form-control" name="{{ $key }}">{{ $setting['value'] }}</textarea>
                    <script>
                        CKEDITOR.replace('{{ $key }}', {
                            height: '110px'
                        });
                    </script>
                @endif
            </div>
        @endif
    @endforeach

    <div class="form-group" style="margin-bottom: 0;">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</form>