<?php

?>
    <link rel="stylesheet" href="../../assets/login/styles.css" type="text/css">
    <link rel="stylesheet" href="../../assets/index/styles.css" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<h3 style="color:white; font-size:20">User: <?= $_SESSION["usersName"] ?></h3>
    <div style="color:white", class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Employees Details</h2>
                        <a href="index.php?controller=employee&action=create" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Employee</a>
                    </div style="color:white">
                    <table style ="color:white" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>Number</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Salary</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($data) { 
                            $count = 0;
                                while($row = $data->fetch(PDO::FETCH_OBJ)){?>
                                    <tr>
                                    <td>  <?= $count+=1 ?>  </td>
                                    <td>  <?= $row->id ?>  </td>
                                    <td>  <?= $row->name?>  </td>
                                    <td>  <?= $row->address ?> </td>
                                    <td>  <?= $row->salary ?> </td>
                                    <td>
                                    <a href="index.php?controller=employee&action=read&id=<?= $row->id ?>" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>
                                    <a href="index.php?controller=employee&action=update&id=<?= $row->id ?>" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                                    <a href="index.php?controller=employee&action=delete&id=<?= $row->id ?>" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                                    </td>
                                    </tr>
                                    <?php } ?>  
                                </tbody>                         
                            </table>

                    <?php
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    ?>
                    
                </div>
            </div>        
        </div>
    </div>
    <div class="floating-container">

  <a href="./index.php?controller=pages&action=home" class="floating-button" name="submit">Home</a>
  <div class="element-container">
  </div>
</div>
</body>
</html>