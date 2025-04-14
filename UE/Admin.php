<?php
// admin.php

// Define the path to the JSON file
$jsonFile = 'data.json';

// Load existing data from the JSON file
$content = [];
if (file_exists($jsonFile)) {
    $content = json_decode(file_get_contents($jsonFile), true);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $content = [
        'logo_url' => $_POST['logoUrl'],
        'welcome_title' => $_POST['welcomeTitle'],
        'welcome_text' => $_POST['welcomeText'],
        'accreditation_button_text' => $_POST['accreditationButtonText'],
        'campus_tour_button_text' => $_POST['campusTourButtonText'],
        'carousel_image1' => $_POST['carouselImage1'],
        'carousel_image2' => $_POST['carouselImage2'],
        'carousel_image3' => $_POST['carouselImage3'],
        'carousel_image4' => $_POST['carouselImage4'],
        'news_title1' => $_POST['newsTitle1'],
        'news_image1' => $_POST['newsImage1Url'], // Default to URL
        'news_date1' => $_POST['newsDate1'],
        'news_title2' => $_POST['newsTitle2'],
        'news_image2' => $_POST['newsImage2Url'], // Default to URL
        'news_date2' => $_POST['newsDate2'],
        'news_title3' => $_POST['newsTitle3'],
        'news_image3' => $_POST['newsImage3Url'], // Default to URL
        'news_date3' => $_POST['newsDate3'],
        'news_title4' => $_POST['newsTitle4'],
        'news_image4' => $_POST['newsImage4Url'], // Default to URL
        'news_date4' => $_POST['newsDate4'],
        'portal_ad_image' => $_POST['portalAdImage'],
        'marquee_text' => $_POST['marqueeText'],
        'background_color' => $_POST['backgroundColor'],
        'text_color' => $_POST['textColor'],
    ];

    // Handle file uploads
    $uploadDir = 'uploads/'; // Directory to store uploaded files
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
    }

    // Function to handle file uploads
    function handleFileUpload($fileInputName, $uploadDir) {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $tmpFilePath = $_FILES[$fileInputName]['tmp_name'];
            $fileName = basename($_FILES[$fileInputName]['name']);
            $filePath = $uploadDir . $fileName;

            // Move the uploaded file to the upload directory
            if (move_uploaded_file($tmpFilePath, $filePath)) {
                return $filePath; // Return the file path
            }
        }
        return null; // Return null if no file was uploaded
    }

    // Handle file uploads for news images
    $content['news_image1'] = handleFileUpload('newsImage1File', $uploadDir) ?? $content['news_image1'];
    $content['news_image2'] = handleFileUpload('newsImage2File', $uploadDir) ?? $content['news_image2'];
    $content['news_image3'] = handleFileUpload('newsImage3File', $uploadDir) ?? $content['news_image3'];
    $content['news_image4'] = handleFileUpload('newsImage4File', $uploadDir) ?? $content['news_image4'];

    // Save the updated data to the JSON file
    file_put_contents($jsonFile, json_encode($content, JSON_PRETTY_PRINT));

    // Redirect to the admin page to avoid form resubmission
    header('Location: admin.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - University of the East</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .admin-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group textarea,
        .form-group input[type="color"],
        .form-group input[type="url"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
            height: 100px;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #0073e6;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #005bb5;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #ff4444;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <!-- Back to Main Page Button -->
    <a href="Home.php" class="back-button">Back to Main Page</a>

    <div class="admin-container">
        <h1>Admin Panel - Edit Content</h1>
        <form id="editForm">
            <!-- Welcome Section -->
            <div class="form-group">
                <label for="welcomeTitle">Welcome Title</label>
                <input type="text" id="welcomeTitle" name="welcomeTitle" value="WELCOME TO THE UNIVERSITY OF THE EAST!">
            </div>
            <div class="form-group">
                <label for="welcomeText">Welcome Text</label>
                <textarea id="welcomeText" name="welcomeText">UE is one of the Philippines’ leading universities, having produced, for 75 years now as of September 2021, over a million alumni who have made their mark as leaders and achievers in various fields of endeavor across the country and around the world.</textarea>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <label for="accreditationButtonText">Accreditation Button Text</label>
                <input type="text" id="accreditationButtonText" name="accreditationButtonText" value="Accreditation Status">
            </div>
            <div class="form-group">
                <label for="campusTourButtonText">Campus Tour Button Text</label>
                <input type="text" id="campusTourButtonText" name="campusTourButtonText" value="Campus Tour">
            </div>

            <!-- Carousel Images -->
            <div class="form-group">
                <label for="carouselImage1">Carousel Image 1 (URL or File)</label>
                <input type="url" id="carouselImage1Url" name="carouselImage1Url" placeholder="Enter URL for Carousel Image 1">
                <input type="file" id="carouselImage1File" name="carouselImage1File" accept="image/*">
            </div>
            <div class="form-group">
                <label for="carouselImage2">Carousel Image 2 (URL or File)</label>
                <input type="url" id="carouselImage2Url" name="carouselImage2Url" placeholder="Enter URL for Carousel Image 2">
                <input type="file" id="carouselImage2File" name="carouselImage2File" accept="image/*">
            </div>
            <div class="form-group">
                <label for="carouselImage3">Carousel Image 3 (URL or File)</label>
                <input type="url" id="carouselImage3Url" name="carouselImage3Url" placeholder="Enter URL for Carousel Image 3">
                <input type="file" id="carouselImage3File" name="carouselImage3File" accept="image/*">
            </div>
            <div class="form-group">
                <label for="carouselImage4">Carousel Image 4 (URL or File)</label>
                <input type="url" id="carouselImage4Url" name="carouselImage4Url" placeholder="Enter URL for Carousel Image 4">
                <input type="file" id="carouselImage4File" name="carouselImage4File" accept="image/*">
            </div>

            <!-- Logo -->
            <div class="form-group">
                <label for="logoUrl">Logo (URL or File)</label>
                <input type="url" id="logoUrl" name="logoUrl" placeholder="Enter URL for Logo">
                <input type="file" id="logoFile" name="logoFile" accept="image/*">
                <br>
                <img id="logoPreview" src="" alt="Logo Preview" style="max-width: 150px; display: none;">
            </div>

            <!-- Marquee Text -->
            <div class="form-group">
                <label for="marqueeText">Marquee Text</label>
                <input type="text" id="marqueeText" name="marqueeText" value="Let Your Tomorrow Begin in the East.">
            </div>

            <!-- Background and Text Colors -->
            <div class="form-group">
                <label for="backgroundColor">Background Color</label>
                <input type="color" id="backgroundColor" name="backgroundColor" value="#f4f4f4">
            </div>
            <div class="form-group">
                <label for="textColor">Text Color</label>
                <input type="color" id="textColor" name="textColor" value="#333333">
            </div>


                        <!-- News Section -->
            <div class="form-group">
                <label for="newsTitle1">News Title 1</label>
                <input type="text" id="newsTitle1" name="newsTitle1" value="Office for International Affairs & External Linkages presents: Asia Africa Forum on Corruption">
            </div>
            <div class="form-group">
                <label for="newsImage1">News Image 1 (URL or File)</label>
                <input type="url" id="newsImage1Url" name="newsImage1Url" placeholder="Enter URL for News Image 1">
                <input type="file" id="newsImage1File" name="newsImage1File" accept="image/*">
            </div>
            <div class="form-group">
                <label for="newsDate1">News Date 1</label>
                <input type="text" id="newsDate1" name="newsDate1" value="February 28, 2025">
            </div>

            <div class="form-group">
                <label for="newsTitle2">News Title 2</label>
                <input type="text" id="newsTitle2" name="newsTitle2" value="UE CALOOCAN WEEK 2025: UPHOLDING EXCELLENCE BEYOND LIMITS">
            </div>
            <div class="form-group">
                <label for="newsImage2">News Image 2 (URL or File)</label>
                <input type="url" id="newsImage2Url" name="newsImage2Url" placeholder="Enter URL for News Image 2">
                <input type="file" id="newsImage2File" name="newsImage2File" accept="image/*">
            </div>
            <div class="form-group">
                <label for="newsDate2">News Date 2</label>
                <input type="text" id="newsDate2" name="newsDate2" value="February 27, 2025">
            </div>

            <div class="form-group">
                <label for="newsTitle3">News Title 3</label>
                <input type="text" id="newsTitle3" name="newsTitle3" value="UE RANKS 9TH IN MLA, 20TH AMONG TOP PHL UNIVERSITIES!">
            </div>
            <div class="form-group">
                <label for="newsImage3">News Image 3 (URL or File)</label>
                <input type="url" id="newsImage3Url" name="newsImage3Url" placeholder="Enter URL for News Image 3">
                <input type="file" id="newsImage3File" name="newsImage3File" accept="image/*">
            </div>
            <div class="form-group">
                <label for="newsDate3">News Date 3</label>
                <input type="text" id="newsDate3" name="newsDate3" value="March 11, 2025">
            </div>

            <div class="form-group">
                <label for="newsTitle4">News Title 4</label>
                <input type="text" id="newsTitle4" name="newsTitle4" value="UE Fine Arts Alumni Set to Honor Alma Mater with Grand Exhibition">
            </div>
            <div class="form-group">
                <label for="newsImage4">News Image 4 (URL or File)</label>
                <input type="url" id="newsImage4Url" name="newsImage4Url" placeholder="Enter URL for News Image 4">
                <input type="file" id="newsImage4File" name="newsImage4File" accept="image/*">
            </div>
            <div class="form-group">
                <label for="newsDate4">News Date 4</label>
                <input type="text" id="newsDate4" name="newsDate4" value="March 10, 2025">
            </div>

            <!-- Portal Ad -->
            <div class="form-group">
                <label for="portalAdImage">Portal Ad Image (URL or File)</label>
                <input type="url" id="portalAdImageUrl" name="portalAdImageUrl" placeholder="Enter URL for Portal Ad Image">
                <input type="file" id="portalAdImageFile" name="portalAdImageFile" accept="image/*">
            </div>
                        <!-- Apply Changes Button -->
            <div class="form-group">
                <button type="button" onclick="applyChanges()">Apply Changes</button>
            </div>

        </form>
    </div>

    <script>
        function applyChanges() {
            // Save welcome section
            localStorage.setItem('welcomeTitle', document.getElementById('welcomeTitle').value);
            localStorage.setItem('welcomeText', document.getElementById('welcomeText').value);

            // Save buttons
            localStorage.setItem('accreditationButtonText', document.getElementById('accreditationButtonText').value);
            localStorage.setItem('campusTourButtonText', document.getElementById('campusTourButtonText').value);

            // Save carousel images (URL or File)
            const carouselImage1Url = document.getElementById('carouselImage1Url').value;
            const carouselImage2Url = document.getElementById('carouselImage2Url').value;
            const carouselImage3Url = document.getElementById('carouselImage3Url').value;
            const carouselImage4Url = document.getElementById('carouselImage4Url').value;

            const carouselImage1File = document.getElementById('carouselImage1File').files[0];
            const carouselImage2File = document.getElementById('carouselImage2File').files[0];
            const carouselImage3File = document.getElementById('carouselImage3File').files[0];
            const carouselImage4File = document.getElementById('carouselImage4File').files[0];

            // Save carousel images (URL takes precedence over file)
            if (carouselImage1Url) {
                localStorage.setItem('carouselImage1', carouselImage1Url);
            } else if (carouselImage1File) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('carouselImage1', e.target.result);
                };
                reader.readAsDataURL(carouselImage1File);
            }

            if (carouselImage2Url) {
                localStorage.setItem('carouselImage2', carouselImage2Url);
            } else if (carouselImage2File) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('carouselImage2', e.target.result);
                };
                reader.readAsDataURL(carouselImage2File);
            }

            if (carouselImage3Url) {
                localStorage.setItem('carouselImage3', carouselImage3Url);
            } else if (carouselImage3File) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('carouselImage3', e.target.result);
                };
                reader.readAsDataURL(carouselImage3File);
            }

            if (carouselImage4Url) {
                localStorage.setItem('carouselImage4', carouselImage4Url);
            } else if (carouselImage4File) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('carouselImage4', e.target.result);
                };
                reader.readAsDataURL(carouselImage4File);
            }

            // Save logo (URL or File)
            const logoUrl = document.getElementById('logoUrl').value;
            const logoFile = document.getElementById('logoFile').files[0];
            if (logoUrl) {
                localStorage.setItem('logoUrl', logoUrl);
            } else if (logoFile) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('logoUrl', e.target.result);
                };
                reader.readAsDataURL(logoFile);
            }

            // Save marquee text
            localStorage.setItem('marqueeText', document.getElementById('marqueeText').value);

            // Save colors
            localStorage.setItem('backgroundColor', document.getElementById('backgroundColor').value);
            localStorage.setItem('textColor', document.getElementById('textColor').value);

            // Save news section
            localStorage.setItem('newsTitle1', document.getElementById('newsTitle1').value);
            localStorage.setItem('newsTitle2', document.getElementById('newsTitle2').value);
            localStorage.setItem('newsTitle3', document.getElementById('newsTitle3').value);
            localStorage.setItem('newsTitle4', document.getElementById('newsTitle4').value);

            localStorage.setItem('newsDate1', document.getElementById('newsDate1').value);
            localStorage.setItem('newsDate2', document.getElementById('newsDate2').value);
            localStorage.setItem('newsDate3', document.getElementById('newsDate3').value);
            localStorage.setItem('newsDate4', document.getElementById('newsDate4').value);

            const newsImage1Url = document.getElementById('newsImage1Url').value;
            const newsImage2Url = document.getElementById('newsImage2Url').value;
            const newsImage3Url = document.getElementById('newsImage3Url').value;
            const newsImage4Url = document.getElementById('newsImage4Url').value;

            const newsImage1File = document.getElementById('newsImage1File').files[0];
            const newsImage2File = document.getElementById('newsImage2File').files[0];
            const newsImage3File = document.getElementById('newsImage3File').files[0];
            const newsImage4File = document.getElementById('newsImage4File').files[0];

            if (newsImage1Url) {
                localStorage.setItem('newsImage1', newsImage1Url);
            } else if (newsImage1File) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('newsImage1', e.target.result);
                };
                reader.readAsDataURL(newsImage1File);
            }

            if (newsImage2Url) {
                localStorage.setItem('newsImage2', newsImage2Url);
            } else if (newsImage2File) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('newsImage2', e.target.result);
                };
                reader.readAsDataURL(newsImage2File);
            }

            if (newsImage3Url) {
                localStorage.setItem('newsImage3', newsImage3Url);
            } else if (newsImage3File) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('newsImage3', e.target.result);
                };
                reader.readAsDataURL(newsImage3File);
            }

            if (newsImage4Url) {
                localStorage.setItem('newsImage4', newsImage4Url);
            } else if (newsImage4File) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('newsImage4', e.target.result);
                };
                reader.readAsDataURL(newsImage4File);
            }

            // Save portal ad
            const portalAdImageUrl = document.getElementById('portalAdImageUrl').value;
            const portalAdImageFile = document.getElementById('portalAdImageFile').files[0];
            if (portalAdImageUrl) {
                localStorage.setItem('portalAdImage', portalAdImageUrl);
            } else if (portalAdImageFile) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    localStorage.setItem('portalAdImage', e.target.result);
                };
                reader.readAsDataURL(portalAdImageFile);
            }

            alert('Changes applied successfully!');
        }
    // Helper function to get image data (either URL or File as Base64)
    async function getImageData(urlInputId, fileInputId) {
        const urlValue = document.getElementById(urlInputId).value.trim();
        if (urlValue !== "") return urlValue; // Use URL if provided

        const fileInput = document.getElementById(fileInputId);
        if (fileInput.files.length > 0) {
            return await readFileAsBase64(fileInput.files[0]); // Convert file to Base64
        }
        return ""; // Return empty if no URL or file is provided
    }

    // Convert File to Base64
    function readFileAsBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => resolve(e.target.result);
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    // Load saved changes from localStorage
    function loadChanges() {
        document.getElementById('welcomeTitle').value = localStorage.getItem('welcomeTitle') || "";
        document.getElementById('welcomeText').value = localStorage.getItem('welcomeText') || "";
        document.getElementById('accreditationButtonText').value = localStorage.getItem('accreditationButtonText') || "";
        document.getElementById('campusTourButtonText').value = localStorage.getItem('campusTourButtonText') || "";
        document.getElementById('carouselImage1Url').value = localStorage.getItem('carouselImage1') || "";
        document.getElementById('carouselImage2Url').value = localStorage.getItem('carouselImage2') || "";
        document.getElementById('carouselImage3Url').value = localStorage.getItem('carouselImage3') || "";
        document.getElementById('carouselImage4Url').value = localStorage.getItem('carouselImage4') || "";
        document.getElementById('logoUrl').value = localStorage.getItem('logoUrl') || "";
        document.getElementById('marqueeText').value = localStorage.getItem('marqueeText') || "";
        document.getElementById('backgroundColor').value = localStorage.getItem('backgroundColor') || "#ffffff";
        document.getElementById('textColor').value = localStorage.getItem('textColor') || "#000000";

        // Load saved logo and update preview
        const savedLogo = localStorage.getItem('logoUrl');
        if (savedLogo) {
            document.getElementById('logoUrl').value = savedLogo.startsWith('data:image') ? "" : savedLogo;
            updateLogoPreview(savedLogo);
        }
    }

    // Update logo preview
    function updateLogoPreview(imageSrc) {
        const logoPreview = document.getElementById('logoPreview');
        if (imageSrc) {
            logoPreview.src = imageSrc;
            logoPreview.style.display = "block";
        } else {
            logoPreview.style.display = "none";
        }
    }

    // Ensure only one input (URL or File) is used at a time
    document.getElementById("logoUrl").addEventListener("input", function () {
        if (this.value.trim() !== "") {
            document.getElementById("logoFile").value = "";
        }
    });

    document.getElementById("logoFile").addEventListener("change", async function () {
        if (this.files.length > 0) {
            document.getElementById("logoUrl").value = "";
            const base64Data = await readFileAsBase64(this.files[0]);
            updateLogoPreview(base64Data);
        }
    });

    // Load changes when the page loads
    window.onload = loadChanges;
</script>

</body>
</html>