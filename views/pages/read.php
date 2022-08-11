
    <link rel="stylesheet" href="../../assets/login/styles.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div style ="color:white" class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-5 mb-3">View Record</h1>
                <div class="form-group">
                    <label>Name</label>
                    <p><b><?php echo $data["name"]; ?></b></p>
                    <div>--------------------</div>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <p><b><?php echo $data["address"]; ?></b></p>
                </div>
                <div>--------------------</div>
                <div class="form-group">
                    <label>Salary</label>
                    <p><b><?php echo $data["salary"]; ?></b></p>
                </div>
                <p><a href="/index.php?controller=employee&action=index" class="btn btn-primary">Back</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>