<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
   <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
       
};
       </script>
  
</head>
<?php
$book_id="";
$book_title="";
$description="";
$year="";
$publisher_title="";
$publisher_id_first="";
 ?>
<body class="px-5">
    <h1 class="my-4">Das Buch bearbeiten</h1>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <?php 
    if(isset($_GET['id'])&&is_numeric($_GET['id'])){
        
    $book_id=intval($_GET['id']);
    
    $host='localhost';
    $username='root';
    $password='';
    $database='library';
    $conn=new mysqli($host,$username,$password,$database);
    $conn->set_charset("utf8");
    $query="SELECT B.ID,B.title AS book_title,B.description,B.publishing_year, P.title AS publisher_title,P.ID AS publisher_id
     FROM books B INNER JOIN publisher P ON B.publisher_id=P.ID WHERE B.ID=".$book_id;
      $result=$conn->query($query);
     if($result->num_rows>0){
        $row=$result->fetch_assoc();
        
        
        
    
    
            $book_title=$row['book_title'];
            
            
            $description=$row['description'];
            $year=intval($row['publishing_year']);
            
            $publisher_title=$row['publisher_title'];
            $publisher_id_first=$row['publisher_id'];

     }
     
    }

    
    ?>
     <div class="col-lg-6">
    <form action="" method='post'>
        <label for="book_id" class="form-label">ID</label>
        <input id="book_id" class="form-control" type="text" name="book_id" value="<?php echo $book_id ?>" readonly >
        <label for="book_title" class="form-label">Book name</label>
        <input id="book_title" class="form-control" type="text" name="book_title" value="<?php echo $book_title ?>" >
        <label for="description" class=form-label>Description</label>
        <input id="description" class="form-control" type="text" name="description" value="<?php echo $description ?>">
        <label for="year" class="form-label">Year</label>
        <input id="year"class="form-control" type="number" name="year" value="<?php echo $year ?>" >
        <label for="publisher" class="form-label">Verlage</label>
    <select id="publisher" name="publisher_id" class="form-select">
        <?php 
            $query_all_publisher="SELECT *  FROM publisher;";
            $result=$conn->query($query_all_publisher);
     if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            
            if($row['ID']===$publisher_id_first){
         echo '<option value="' . $row['ID'] . '" selected>' . $row['title'] . '</option>';
            }else{
                echo '<option value="' . $row['ID'] . '" >' . $row['title'] . '</option>';
            }

        }}
        ?>
        </select>
        <div class="text-center">
     
        <input type="submit" value="Submit" class="btn btn-primary mt-4"> 
    </div>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

<?php
if(isset($_POST['book_id'])&&isset($_POST['book_title'])&&isset($_POST['description'])
&&isset($_POST['year'])&&isset($_POST['publisher_id'])&&is_numeric($_POST['year'])){
    $book_title_input=filter_var($_POST['book_title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $description_input=filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
    $year_input=$_POST['year'];
if(!filter_var($year,FILTER_VALIDATE_INT,array("options"=>
array("min_range"=>1000, "max_range"=>date('Y'))))){
echo 
'<script>
window.alert("Falsch Format des Jahres");
</script>';
}else{
    

    $query_update_books="UPDATE books SET title='" . $book_title_input. "',
                description='" . $description_input. "',
                publishing_year='" .$year_input . "' ,
                publisher_id='".$_POST['publisher_id']."'
                WHERE ID='" . $_POST['book_id'] . "';";
    
    $result=$conn->query($query_update_books);
    if($result){
        echo '<script>
        window.alert("Updated");
        </script>';

        echo '<script>
        location.reload();
        </script>';
        

    }else{
        echo '<script>
        window.alert("Error");
        </script>';

    }

   
    


}



}
 ?>
</html>