<style>
@media (min-width:768px){
    .grid {
    display: grid;
    height: 100%;

    grid-template-rows: 0.1fr 1.1fr;
    grid-template-columns: 1fr 2.8fr 1fr;
    grid-template-areas: 
    "t t t"
    "m1 m2 m3";
    }
}
@media (max-width: 768px){
    .grid {
    display: grid;
    grid-template-rows: repeat(auto-fill, minmax(140px,1fr));
    grid-template-columns: 1fr;
    grid-template-areas: 
    "t"
    "m2"
    "m1"
    "m3";
    }
    .m1{
        grid-area: m1;
        border-bottom: 4px solid #ffc107;
    }
    .m2{
        grid-area: m2;
        border-bottom: 4px solid #ffc107;
    }
    .m3{
        grid-area: m3;
        overflow-y: auto;
        max-height: 50vh;
    }
}

.t{
    grid-area: t;
    border-bottom: 4px solid #ffc107;
}
.m1{
    grid-area: m1;
}
.m2{
    grid-area: m2;
}
.m3{
    grid-area: m3;
    overflow-y: auto;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Hangman</title>
</head>
<body>
<div class="grid">
    <div class="t bg-dark text-light d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="container-fluid bg-dark text-light p-3 flex-shrink-1">
            <div class="row align-items-center">
                <div class="col-md d-flex justify-content-center justify-content-md-start">
                    <h6 class="m-md-0">Logged in as kokot</h6>
                </div>
                <div class="col-md d-flex justify-content-center">
                    <h4 class="m-md-0">Maths Game</h4>
                </div>
                <div style="white-space: nowrap;" class="col-md d-flex justify-content-center justify-content-md-end">
                    <button class="btn btn-primary mx-2">Profile</button>
                    <button class="btn btn-primary mx-2">Back to hub</button>
                    <button class="btn btn-danger mx-2">Logout</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="m1 bg-dark text-center text-light p-2 p-md-3">
        <div class="">
            <h4>Leaderboard</h4>
        </div>
        <hr>
        <div class="">
            <table class="table text-center table-dark table-borderless">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Score</th>
            </tr>
            <tr>
                <td>1.</td>
                <td>Smith</td>
                <td>50</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Jacksasdsda</td>
                <td>94</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Jackson</td>
                <td>94</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Jackson</td>
                <td>94</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Smith</td>
                <td>50</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Jacksasdsda</td>
                <td>94</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Jackson</td>
                <td>94</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Jackson</td>
                <td>94</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Jackson</td>
                <td>94</td>
            </tr>
            <tr>
                <td>10.</td>
                <td>Jackson</td>
                <td>94</td>
            </tr>
            </table>
            <div class="d-flex align-items-center justify-content-center">
                <button style="width: 35%;" class="btn btn-primary mx-2">Previous</button>
                <h6>Page 1/2</h6>
                <button style="width: 35%;" class="btn btn-primary mx-2">Next</button>
            </div>
        </div>
        
    </div>
    <div class="m2 text-center bg-secondary p-3 p-md-5">
        <div class="rounded bg-dark text-light d-inline-block p-3 mb-4">
            <h3 class="m-0">123 + 456</h3>
            <hr>
            <input type="text" class="form-control">
            <input type="button" class="form-control btn bg-success text-light mt-1" value="Odeslat">
        </div>
        <hr class="bg-light">
        <div class="row mt-4 text-white">
            <div class="col">
                <h5>Session Score:</h5>
                <p class="lead m-0">123</p>
            </div>
            <div class="col">
                <h5>In Row Correct:</h5>
                <p class="lead m-0">789</p>
            </div>
            <div class="col">
                <h5>Total Score:</h5>
                <p class="lead m-0">456</p>
            </div>
        </div>
    </div>
    <div class="m3 bg-dark text-light text-center p-md-3 pt-md-0">
        <div style="position: sticky;top: 0;z-index: 2;" class="bg-dark py-md-3">
            <h4>Achievements</h4>
            <hr class="mb-0">
        </div>
        
        <div class="">
            <div class="card bg-success my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
            <div class="card bg-success my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
            <div class="card bg-secondary my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
            <div class="card bg-secondary my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
            <div class="card bg-secondary my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
            <div class="card bg-success my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
            <div class="card bg-success my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
            <div class="card bg-secondary my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
            <div class="card bg-secondary my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
            <div class="card bg-secondary my-1">
                <div class="card-header">Godlike</div>
                <div class="card-body">
                    <p class="card-text">Get score of 100 in Maths Game.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>