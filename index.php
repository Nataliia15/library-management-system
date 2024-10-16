<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script>
        // Reload the page when coming back from another page
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload(); // Reload the page
            }
        };
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
       
};

</script>
    
</head>
<?php 
$host='localhost';
$username='root';
$password='';
$database='library';
$conn=new mysqli($host,$username,$password,$database);

?>
<body class="px-4">
    <h1>Unsere Bibliothek</h1>
    <div container>
        <div class="col-lg-6">
    <form action="" method="post" class="mb-3">
        <label for="book_title" class="form-label">Title</label>
        <input type="text" name="book_title" id="book_title" class="form-control">
        <label for="description" class="form-label">Description</label>
        <input type="text" name="description" id="description" class="form-control">
        <label for="year" class="form-label">Year</label>
        <input type="text" name="year" id=year class="form-control"> 
        <label for="publisher" class="form-label">Verlage</label>
        <select id="publisher" name="publisher_id" class="form-select">
        <?php 
            $query_all_publisher="SELECT *  FROM publisher;";
            $result=$conn->query($query_all_publisher);
     if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
         echo '<option value="' . $row['ID'] . '">' . $row['title'] . '</option>';

        }}
     ?>

        </select>
        
        <input type="submit" value= "Buch anlegen" class="mt-4 btn btn-primary"  >
    </form>
    </div>
    <?php

    if(isset($_POST['book_title'])&&isset($_POST['description'])
    &&isset($_POST['year'])&&isset($_POST['publisher_id'])&&is_numeric($_POST['publisher_id'])){
        $book_title=filter_var($_POST['book_title'], FILTER_SANITIZE_SPECIAL_CHARS);
        $description=filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        $year=$_POST['year'];
if(!filter_var($year,FILTER_VALIDATE_INT,array("options"=>
array("min_range"=>1000, "max_range"=>date('Y'))))){
    echo '<script>
    window.alert("Falsch Format des Jahres");
    </script>';
}else{

$query_create_book = 'INSERT INTO books (title, description, publishing_year, publisher_id) 
VALUES ("' . $book_title . '", "' . $description . '", ' . $year . ', ' .$_POST['publisher_id'] . ')';
echo $_POST['publisher_id'];

    if($conn->query($query_create_book)===TRUE){
        echo '<script>
            window.alert("Added");
            </script>';
    }else {echo '<script>
            window.alert("Error");
            </script>';}


    }}
     ?>
    <table class="table table-striped-columns table-hover ">
        <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Year</th>
        <th>Publisher</th>
</tr>
    <?php 
    
    $query='SELECT B.ID,B.title AS book_title,B.description,B.publishing_year, P.title AS publisher_title
     FROM books B INNER JOIN publisher P ON B.publisher_id=P.ID;';
     $result=$conn->query($query);
     if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            $delete_book_by_id=$row['ID'];

            
            
           echo '<tr>';
           echo '<td>'.$row['ID'].'</td>';
           echo '<td>'.$row['book_title'].'</td>';
           echo '<td>'.$row['description'].'</td>';
           echo '<td>'.$row['publishing_year'].'</td>';
           echo '<td>'.$row['publisher_title'].'</td>';
           echo '<td><a href="http://localhost/library/update_form.php?id='.$row['ID'].'">
           <button class="btn btn-warning">Bearbeiten</button>
           </a></td>';
           //form for deletenig
           echo '<td><form action="" method="post">
           <input type="hidden" name="delete_book_by_id" value="' . $delete_book_by_id. '">
           <input type="submit" value="Löschen" class="btn btn-danger">
           </form>
           </td>';
           echo '</tr>';          
        }
     }
    
     if(isset($_POST['delete_book_by_id'])){
        $query_delete_book="DELETE FROM books WHERE ID='" . $_POST['delete_book_by_id'] . "';";
        
        $result=$conn->query($query_delete_book);
        if($result){
            echo '<script>
            window.alert("Deleted");
            </script>';

        }else{
            echo '<script>
            window.alert("Error");
            </script>';

        }
        
        echo '<script>
    location.reload();
    </script>';

    
        
       
     }
     
    

    ?>
   </table> 
    </div>
    
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>