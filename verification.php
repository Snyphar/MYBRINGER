<?php
// Start the session
session_start();

// Other PHP code goes here
?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'db_connect.php';
$error = "";
$registered = false; 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];

    $country = $_POST['country'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $zip = $_POST['zip'];

//     echo "Email: " . $email . "<br>";
// echo "Contact Number: " . $contact_no . "<br>";
// echo "Address: " . $address . "<br>";

// echo "Country: " . $country . "<br>";
// echo "City: " . $city . "<br>";
// echo "Gender: " . $gender . "<br>";
// echo "Zip: " . $zip . "<br>";
    
    // Process verification status, you may have additional verification steps
    $verification_status = "verified"; // Set verification status, you may change this based on your verification process
    
    // File handling
    $nid_file = $_FILES['nid'];
    $passport_file = $_FILES['passport'];

    
    if (empty($contact_no)) {
        $error .= "Contact number is required! ";
    }
    if (empty($address)) {
        $error .= "Address is required! ";
    }
    if (empty($country)) {
        $error .= "Country is required! ";
    }
    if (empty($city)) {
        $error .= "City is required! ";
    }
    
    if (empty($zip)) {
        $error .= "Zip code is required! ";
    }
    

    if (empty($_FILES['nid']['name']) && empty($_FILES['passport']['name'])) {
        // Check if at least one of nid or passport is present
        $error = "You must upload at least one of NID or Passport!";
    }
    if(empty($error)){
        // Directory where uploaded files will be saved
        $upload_directory = "uploads/";

        // Move uploaded files to the server
        $nid_file_path = $upload_directory . basename($nid_file['name']);
        $passport_file_path = $upload_directory . basename($passport_file['name']);

        if (move_uploaded_file($nid_file['tmp_name'], $nid_file_path) || move_uploaded_file($passport_file['tmp_name'], $passport_file_path)) {
            // Files were successfully uploaded
            // Proceed with database update
            // Prepare SQL statement to update verification status
            $sql = "UPDATE users SET verified = ?, 
                        
                        contact_no = ?, 
                        address = ?, 
                        country = ?, 
                        city = ?, 
                        gender = ?, 
                        zip = ?, 
                        nid = ?, 
                        passport = ?,
                        verified = 1  
                    WHERE id = ?";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bind_param("sssssssssi", $verification_status,  $contact_no, $address, $country, $city, $gender, $zip, $nid_file_path, $passport_file_path, $_SESSION['id']);
                    
            // Execute the statement
            if ($stmt->execute()) {
                // Verification successful
                $verified = true;

                
                $_SESSION['contact_no'] = $contact_no;
                
               
                $_SESSION['country'] = $country;
                $_SESSION['city'] = $city;
                
                $_SESSION['address'] = $address;
                
                $_SESSION['zip'] = $zip;
                
                $_SESSION['verified'] = 1;
                header("Location: index.php");
                

            } else {
                // Verification failed
                $error =  $conn->error;
                echo "Error: " . $conn->error;
            }
        } else {
            // File upload failed
            echo "File upload failed!";
        }
    }

    
    
    
    
}

// Close the connection
$conn->close();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    

    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
        }

        .card-header h4 {
            font-family: Helvetica, Arial, sans-serif;
        }

        .card-header span {
            font-family: Helvetica, Arial, sans-serif;
        }
        .rounded-buttons .btn {
            border-radius: 20px; /* Adjust the border-radius value for desired roundness */
        }
        .cover-section {
            background-image: url('./assets/images/blulaggon_cover.jpg'); /* Your background image URL */
            background-size: cover;
            padding-bottom: 80px;
            
            margin: 0;
            
        }
        
        .typing-effect {
            font-size: 3em;
            text-align: center;
            overflow: hidden;
            border-right: .15em solid orange;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: .15em;
            animation: typing 3.5s steps(40, end), blink-caret .75s step-end infinite;
        }

        /* The typing effect animation */
        @keyframes typing {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        /* The blinking cursor animation */
        @keyframes blink-caret {
            from, to {
                border-color: transparent;
            }
            50% {
                border-color: orange;
            }
        }
        .transparent {
            background-color: rgba(255, 255, 255, 0.0); /* Set background color with transparency */
            
        }
        .transparent-header {
            background-color: transparent !important; /* Important to override default Bootstrap styling */
        }
        header-option-btn{
            border-radius: 50%;
        }


        #video {
            border: 1px solid black;
            width: 320px;
            height: 240px;
        }

        #photo {
            border: 1px solid black;
            width: 320px;
            height: 240px;
        }

        #canvas {
            display: none;
        }

        .camera {
            width: 340px;
            display: inline-block;
        }

        .output {
            width: 340px;
            display: inline-block;
        }

        

        
        

        
    </style>
    <!-- favicon -->
    <link rel="icon" href="./Imgs/icons/Vector.png" />
    
    
    <script defer src="js/script.js"></script>
    <script defer src="js/countries.js"></script>

    <link
    rel="stylesheet"
    href="https://unpkg.com/swiper@8/swiper-bundle.min.css"
/>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <!-- script tag -->
    <script defer src="./JS/countries.js"></script>

    <!-- ScrollReveal -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- swiper js -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper@8/swiper-bundle.min.css"
    />

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    // Check if the registration was successful
    
    ?>
    
</head>
<body onload="loadCountries()">
<?php include'navbar.php'; ?>


<div class="container-fluid cover-section">
    <div class="container mt-3 typing-conatiner pt-5">
        <div class="typing-effect transparent">
            Send, receive, and carry parcels.
        </div>
    </div>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1>Verify Account   </h1>
                <label for="exampleInputEmail1" class="form-label"><?php  echo $error;?></label>
                
                <form method="post" id="verification_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="row">
                        
                        <div class="col-6">
                            
                            <div class="camera">
                                <label for="exampleInputEmail1" class="form-label">Verification Image*</label>
                                <video id="video">Camera stream not available.</video>
                            </div>
                            <canvas id="canvas"></canvas>
                            <div class="mt-3">
                                
                                <button class="btn btn-outline-success my-2 my-sm-0" id="startbutton">Capture</button>
                                
                            </div>
                        
                        
                        </div>
                        <div class="col-6">
                            <div class="output">
                                <label for="exampleInputEmail1" class="form-label">Captured Image*</label>
                                <img id="photo" alt="The screen capture will appear in this box.">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      
                      <div class="col-6 mb-3">
                        <label for="exampleInputEmail1" class="form-label">Contact No*</label>
                        <input type="tel" name="contact_no" class="form-control p-4" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                      </div>
                    </div>
                    
                    
                    
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Address*</label>
                      <textarea name="address" id="" cols="10"  class="form-control p-4" required></textarea>
                      <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    <div class="row">
                      
                      <div class="col-6 mb-3">
                        <label for="countrySelect" class="form-label">Country*</label>
                        <select id="countrySelect" name="country" class="form-select" onchange="updateCityDropdown()" required>
                            <!-- Country options will be populated dynamically -->
                        </select>
                      </div>
                      <div class="col-6 mb-3">
                        <label for="citySelect" class="form-label">States/City*</label>
                        <select id="citySelect" name="city" class="form-select" onchange="applySelection()" required>
                            <option value="">Select City</option>
                            <!-- City options will be populated dynamically based on the selected country -->
                        </select>
                      </div>
                      
                    
                    </div>
                    <div class="row">
                      <div class="col-6 mb-3">
                        <label for="countrySelect" class="form-label">Gender*</label><br>
                        <select  name="gender" class="form-select" required>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                            <option value="2">Others</option>
                        </select>
                      </div>
                      <div class="col-6 mb-3">
                        <label for="citySelect" class="form-label">ZIP Code*</label>
                        <input type="number" name="zip" class="form-control p-4" id="" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 mb-3">
                        <label for="exampleInputEmail1" class="form-label">Natinal ID*</label>
                        <input type="file" name="nid" id="nid">
                        
                      </div>
                      <div class="col-6 mb-3">
                        <label for="exampleInputEmail1" class="form-label">Passport No*</label>
                        <input type="file" name="passport" id="fileToUpload">
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                      </div>
                    </div>
                    
    
                   
                    
    
                    
                
                    
                    <button type="submit" id="submitBtn" class="btn btn-primary p-3 w-100 mt-5" style="font-size: 20px; display:none">Submit</button>
                  </form>
            </div>
            <button id="verifyBtn" class="btn btn-danger p-3 w-100 mt-5" style="font-size: 20px;">Verify</button>
        </div>
    </div>
</div>





<!-- Bootstrap JS dependencies -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script src="./js/face-api.min.js"></script>

<?php
if ($registered){
  echo '<script>
          Swal.fire({
              icon: "success",
              title: "Registration Successful!",
              text: "You have successfully registered.",
              confirmButtonText: "OK"
          }).then((result) => {
              // Redirect to login page after user clicks OK
              if (result.isConfirmed || result.isDismissed) {
                  window.location.href = "login.php";
              }
          });
      </script>';
}
?>
<script>
    /* JS comes here */
    (function() {

        var width = 320; // We will scale the photo width to this
        var height = 0; // This will be computed based on the input stream

        var streaming = false;

        var video = null;
        var canvas = null;
        var photo = null;
        var startbutton = null;

        function startup() {
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            photo = document.getElementById('photo');
            startbutton = document.getElementById('startbutton');

            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.log("An error occurred: " + err);
                });

            video.addEventListener('canplay', function(ev) {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);

                    if (isNaN(height)) {
                        height = width / (4 / 3);
                    }

                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    streaming = true;
                }
            }, false);

            startbutton.addEventListener('click', function(ev) {
                takepicture();
                ev.preventDefault();
            }, false);

            clearphoto();
        }


        function clearphoto() {
            var context = canvas.getContext('2d');
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        }

        function takepicture() {
            var context = canvas.getContext('2d');
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                var data = canvas.toDataURL('image/png');
                photo.setAttribute('src', data);
            } else {
                clearphoto();
            }
        }

        window.addEventListener('load', startup, false);
    })();
    
</script>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('verifyBtn').addEventListener('click', function() {
            const fileInput = document.getElementById('fileToUpload');
            if (fileInput.files.length === 0) {
                alert('Please select a file.');
                return;
            }
            const file = fileInput.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                const image1 = await faceapi.bufferToImage(document.getElementById('photo').src.blob());
                console.log(image1);
                const image2 = document.createElement('img');
                
                image2.src = reader.result;
                

                Promise.all([
                    
                    faceapi.nets.faceRecognitionNet.loadFromUri('./js/models'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('./js/models'),
                    faceapi.nets.ssdMobilenetv1.loadFromUri('./js/models')
                    
                ]).then(start)

                async function start() {
                    const container = document.createElement('div')
                    container.style.position = 'relative'
                    document.body.append(container)
                    const labeledFaceDescriptors = await loadLabeledImages()
                    const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6)
                    let image
                    let canvas
                    document.body.append('Loaded')
                    imageUpload.addEventListener('change', async () => {
                        if (image) image.remove()
                        if (canvas) canvas.remove()
                        image = await faceapi.bufferToImage(imageUpload.files[0])
                        container.append(image)
                        canvas = faceapi.createCanvasFromMedia(image)
                        container.append(canvas)
                        const displaySize = { width: image.width, height: image.height }
                        faceapi.matchDimensions(canvas, displaySize)
                        const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
                        const resizedDetections = faceapi.resizeResults(detections, displaySize)
                        const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
                        results.forEach((result, i) => {
                        const box = resizedDetections[i].detection.box
                        const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
                        drawBox.draw(canvas)
                        })
                    })
                }
                // Load face-api models
                
            };
            reader.readAsDataURL(file);
        });
    });
</script> -->
<script>
var image_verify = false;
    const imageUpload = document.getElementById('nid')
    const verifyBtn = document.getElementById('verifyBtn')

Promise.all([
  faceapi.nets.faceRecognitionNet.loadFromUri('./js/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('./js/models'),
  faceapi.nets.ssdMobilenetv1.loadFromUri('./js/models')
]).then(start)

async function start() {
  const container = document.createElement('div')
  container.style.position = 'relative'
  document.body.append(container)
//   const labeledFaceDescriptors = await loadLabeledImages()
//   const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6)
  let image
  let canvas
  document.body.append('Loaded')
  verifyBtn.addEventListener('click', async () => {
    
    console.log("clicked");
    const img = document.getElementById('photo')
    const detections1 = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
    const descriptions = []
    descriptions.push(detections1.descriptor)
    const labeledFaceDescriptors = new faceapi.LabeledFaceDescriptors("Match", descriptions)
    const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6)

    image = await faceapi.bufferToImage(imageUpload.files[0])
    container.append(image)
    canvas = faceapi.createCanvasFromMedia(image)
    container.append(canvas)
    const displaySize = { width: image.width, height: image.height }
    faceapi.matchDimensions(canvas, displaySize)
    const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
    results.forEach((result, i) => {
    //   const box = resizedDetections[i].detection.box
    //   const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
    //   drawBox.draw(canvas)
        console.log(result);
        console.log(result.Match)
        if(result.label === "Match"){
            image_verify = true
            Swal.fire({
                icon: "success",
                title: "Image Match Successful!",
                text: "You have successfully verified.",
                confirmButtonText: "OK"
            }).then((result) => {
                // Redirect to login page after user clicks OK
                if (result.isConfirmed || result.isDismissed) {
                    var button = document.getElementById("submitBtn");
                    button.style.display = "block"; 
                    verifyBtn.style.display = "none";
                }
            });
        }
        else{
            image_verify = true
            Swal.fire({
                icon: "danger",
                title: "Image Doesn't Match!",
                text: "Verification Failed.",
                confirmButtonText: "OK"
            }).then((result) => {
                // Redirect to login page after user clicks OK
                if (result.isConfirmed || result.isDismissed) {
                    console.log("Not Verified");
                }
            });
        }
        

    })
  })
}

function loadLabeledImages() {
  const labels = ['Black Widow', 'Captain America', 'Captain Marvel', 'Hawkeye', 'Jim Rhodes', 'Thor', 'Tony Stark']
  return Promise.all(
    labels.map(async label => {
      const descriptions = []
      for (let i = 1; i <= 2; i++) {
        const img = await faceapi.fetchImage(`https://raw.githubusercontent.com/WebDevSimplified/Face-Recognition-JavaScript/master/labeled_images/${label}/${i}.jpg`)
        
        const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
        descriptions.push(detections.descriptor)
      }

      return new faceapi.LabeledFaceDescriptors(label, descriptions)
    })
  )
}
</script>
</body>
</html>
