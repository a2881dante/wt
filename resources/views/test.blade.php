<!DOCTYPE html>
<html>
<body>

<form action="{{url('api/data/update-zips')}}" method="post" enctype="multipart/form-data">
    Select image to upload:
    @csrf
    <input type="file" name="csv_file" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>