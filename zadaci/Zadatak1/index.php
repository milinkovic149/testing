<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="functions">
        <div class="inputs-bck">
            <div class="inputs">
                <form action="" method="POST">
                    <label for="sorting-list">Sort by:</label>
                    <select name="sorting-list[]">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="title">Title</option>
                        <option value="duration">Duration</option>
                        <option value="publish">Publish</option>
                    </select>
                    <input type="submit" name="submit"> <br> <br>
                </form>
                <form action="" method="GET">
                    <input type="text" name="search" class="search" placeholder="search by name" />
                    <input type="number" name="number" class="number" placeholder="search by duration"/>
                    <input type="submit" name="Search" value="Search"><br> <br>
                </form>
                <form action="" method="GET">
                    Show videos that are shorter than 60 s <br>
                    <input type="submit" name="shorter" value="<60"> <br><br><br>
                </form>
                <form action="" method="GET">
                    <input type="submit" name="restart" value="Restart">
                </form>
            </div>
        </div>
    </div>
    <table>
        <tr>
            <th><a href="index.php?hello=true"></a> Title</th>
            <th>Image</th>
            <th>Thumbnail</th>
            <th>Duration</th>
            <th>Publish</th>
        </tr>
        <?php
        $json_data = file_get_contents("https://services.brid.tv/services/mrss/latest/1/0/1/25/0.json");
        $elements = json_decode($json_data, true);
        $videos = $elements['Video'];

        if (isset($_POST['submit'])) {
            if (!empty($_POST['sorting-list'])) {
                foreach ($_POST['sorting-list'] as $selected) {
                    if ($selected == "duration") {
                        $duration = array_column($videos, 'duration');
                        array_multisort($duration, SORT_ASC, $videos);
                    } elseif ($selected == "publish") {
                        $publish = array_column($videos, 'publish');
                        array_multisort($publish, SORT_ASC, $videos);
                    } elseif ($selected == "title") {
                        setlocale(LC_ALL,"US");
                        $name = array_column($videos, 'name');
                        array_multisort($name, SORT_LOCALE_STRING   , $videos);
                    }
                }
            }
        }

        if (isset($_GET['search']) && $_GET['search'] != "") {
            $search = $_GET['search'];
        }
        if (isset($_GET['number']) && $_GET['number'] != "") {
            $searchDuration = $_GET['number'];
        }

        if (isset($_GET["w1"])) {
            $id = $_GET["w1"];
        }

        function setColors($video){
            $shorter = "shorter";
            $middle = "middle";
            $longest = "longest";
            
            if ($video['duration'] <= 60) {
                $class = $shorter;
            } elseif ($video['duration'] > 60 && $video['duration'] <= 120) {
                $class = $middle;
            } else {
                $class = $longest;
            }

            return $class;
        }

        foreach ($videos as $video) {
            $hide = "hide";
            $class=setColors($video);

            //importing str_contains function
            if (!function_exists('str_contains')) {
                function str_contains(string $haystack, string $needle): bool
                {
                    return '' === $needle || false !== strpos($haystack, $needle);
                }
            }

            if (isset($search)) {
                if (!str_contains(strtolower($video['name']), strtolower($search))) {
                    $class = $hide;
                }
            }

            if (isset($searchDuration)) {
                if ($searchDuration!=$video['duration']) {
                    $class = $hide;
                }
            }

            if(isset($search) && isset($searchDuration)){
                if(str_contains(strtolower($video['name']), strtolower($search)) || $searchDuration==$video['duration']){
                    $class=setColors($video);
                }
            }

            if (isset($_GET['shorter'])) {
                if ($video['duration'] > 60) {
                    $class = $hide;
                }
            }

            if (isset($_GET['restart'])) {
                header('location:index.php');
            }

            if (isset($id)) {
                if ($video['id'] == $id) {
                    $class = $hide;
                }
            }

        ?>
            <tr id="datas" class="<?php echo $class ?> ">
                <td name="name"><?php echo $video['name'] ?></td>
                <td name="image">
                    <?php
                        imageExist($video['image'])
                    ?>
                </td>
                <td name="thumbnail">
                    <?php
                        imageExist($video['thumbnail'])
                    ?>
                <td name="duration"><?php echo $video['duration'] ?></td>
                <td name="publish" style="width: 200px"><?php echo $video['publish'] ?> <button type="btn" id="<?php echo $video['id'] ?>">Exclude</button></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <?php
    function imageExist($image)
    {
        if ($image != "") {
    ?>
            <img src="<?php echo $image ?>">
    <?php
        } else echo "Fotografija ne postoji!";
    }
    ?>
    <script src="script.js"></script>
</body>

</html>