<html>
<head>
    <link rel="stylesheet" type="text/css" href="libs/chosen/chosen.min.css"/>
</head>
<body>



<select class="my_select_box" multiple="true" name="faculty" style="width:200px;">
    <option value="AC">A</option>
    <option value="AD">B</option>
    <option value="AM">C</option>
    <option value="AP">D</option>
</select>


<script type="text/javascript" src="libs/DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="libs/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="JS/user_new_dog.js"></script>
<script type="text/javascript">
    $(function() {
        $(".chzn-select").chosen();
    });
    $(".my_select_box").chosen({
        disable_search_threshold: 10,
        no_results_text: "Oops, nothing found!",
        width: "95%"
    });
</script>
</body>
</html>