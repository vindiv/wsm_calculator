<form method="POST" action="{{ route('carica-xml') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file_xml">
    <button type="submit">Carica XML</button>
</form>