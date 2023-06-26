<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humble's Cook's</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <link rel="shortcut icon" href="{{ asset('/rumah/images/favicon/hc.png')}}" type="image/x-icon">


    <link rel="stylesheet" href="{{ asset('/rumah/css/main.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href=
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css"> </link>
    <link rel="stylesheet" href="{{ asset('/rumah/css/font-awesome.min.css')}}">
</head>


    <!-- header -->
    @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
    <!-- ./header -->

    <!-- navbar -->
    <nav class="bg-gray-800">
        <div class="container flex">
            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="pages/shop.html" class="text-gray-200 hover:text-white transition">Shop</a>
                    <a href="#" class="text-gray-200 hover:text-white transition">About us</a>
                    <a href="#" class="text-gray-200 hover:text-white transition">Contact us</a>
                </div>
                <div style="text-align: right;" class="flex items-center space-x-4">
                @if (Route::has('login'))
                
                    @auth
                         <a href="{{ __('logout') }}" method="POST" class="text-gray-200 hover:text-white transition">Logout</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-200 hover:text-white transition">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-200 hover:text-white transition mr-12">Register</a>
                        @endif
                    @endauth
                
            @endif
                </div>
            </div>
        </div>
    </nav>


    <body>
            
        <div class="container" id="section1">
            {{-- Add picture --}}
    <div class="container" style="height: 350px; width: 430px; position: relative;">
        <div class="wrapper" style="position: relative;
        height: 300px;
        width: 100%;
        border-radius: 10px;
        background: #fff;
        border: 2px dashed #c2cdda;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;">
           <div class="image" style="position: absolute;height: 100%;display: flex;align-items: center;justify-content: center;">
              <img id="hslimg" alt="" style="height: 100%;width: 100%;object-fit: cover;">
           </div>
           <div class="content">
              <div class="icon" style="font-size: 100px;
              color: #9658fe;">
                 <img src="{{ ('rumah\images\add-image 1.png') }}"></img>
              </div>
              <div class="text" style="font-size: 20px;
              font-weight: 500;
              color: #000000;">
                 Tambahkan Foto Resep
              </div>
           </div>
           <div id="cancel-btn">
              <i class="fas fa-times"></i>
           </div>
           <div class="file-name">
              File name here
           </div>
        </div>
        <h2 style="font-size: 20px; text-align: center; font-weight:500; padding : 5px; ">Tunjukkan foto hasil akhir makananmu</h2>
        <button onclick="defaultBtnActive()" id="custom-btn">Choose a file</button>
        <input id="default-btn" type="file" hidden>
     </div>
     <script>
        const wrapper = document.querySelector(".wrapper");
        const fileName = document.querySelector(".file-name");
        const defaultBtn = document.querySelector("#default-btn");
        const customBtn = document.querySelector("#custom-btn");
        const cancelBtn = document.querySelector("#cancel-btn i");
        const img = document.querySelector("#hslimg");
        let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;
        function defaultBtnActive(){
          defaultBtn.click();
        }
        defaultBtn.addEventListener("change", function(){
          const file = this.files[0];
          if(file){
            const reader = new FileReader();
            reader.onload = function(){
              const result = reader.result;
              img.src = result;
              wrapper.classList.add("active");
            }
            cancelBtn.addEventListener("click", function(){
              img.src = "";
              wrapper.classList.remove("active");
            })
            reader.readAsDataURL(file);
          }
          if(this.value){
            let valueStore = this.value.match(regExp);
            fileName.textContent = valueStore;
          }
        });
     </script>
    {{-- End add picture --}}

    {{-- Start Form Judul--}}

    <form>
        <div class="form-group" id="form-judul">
            <label for="formGroupExampleInput">Judul Resep</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
          </div>

          <div class="form-group">
            <label for="exampleFormControlTextarea1">Cerita Dibalik Resep Ini</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
          </div>
          <div class="row mb-3">
            <label for="porsi" class="col-sm-2 col-form-label">Porsi</label>
            <div class="col-sm-10">
            <input type="email" class="form-control" id="porsi">
            </div>
        </div>
        <div class="row mb-3">
            <label for="lama-masak" class="col-sm-2 col-form-label">Lama Memasak</label>
            <div class="col-sm-10">
            <input type="password" class="form-control" id="lama-masak">
            </div>
        </div>
        


    </form>
        {{-- End Form judul--}}

    </div>
        

        {{-- Start form bahan --}}
        <div class="container" id="section2">
            <h6 style="font-size: 20px; font-weight: bold">Bahan - Bahan</h6>
            <div id="bahan"></div>
            <div class="form-group">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Default input">
                <div class="input-group-btn">
                    <button class="btn btn-success" type="button"  onclick="bahan();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
                </div>
                </div>
            </div>
            <div class="clear"></div>
            
            
            
          <script>
            var room = 1;
            function bahan() {
            
                room++;
                var objTo = document.getElementById('bahan')
                var divtest = document.createElement("div");
                divtest.setAttribute("class", "form-group removeclass"+room);
                var rdiv = 'removeclass'+room;
                divtest.innerHTML = '<div class="form-group"><div class="input-group"><input class="form-control" type="text" placeholder="Default input"> <div class="input-group-btn">  <button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="glyphicon glyphicon-minus"></span> </button></div></div></div><div class="clear"></div>';
                
                objTo.appendChild(divtest)
            }
            function remove_education_fields(rid) {
                $('.removeclass'+rid).remove();
            }
          </script>

        </div>
        {{-- End form bahan --}}


        {{-- section 3 --}}
        <div class="container" id="section3">
            <h6 style="font-size: 20px; font-weight: bold">Langkah</h6>
            <div id="langkah"></div>
            <div class="form-group">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Default input">
                <div class="input-group-btn">
                    <button class="btn btn-success" type="button"  onclick="langkah();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
                </div>
                </div>
            </div>
            
            <div class="drop-zone">
                <span class="drop-zone__prompt">Tambahkan foto langkah memasak</span>
                <input type="file" name="myFile" id="drop-zone-input">
            </div>

            <script>
                document.querySelectorAll("#drop-zone-input").forEach((inputElement) => {
                const dropZoneElement = inputElement.closest(".drop-zone");

                dropZoneElement.addEventListener("click", (e) => {
                    inputElement.click();
                });

                inputElement.addEventListener("change", (e) => {
                    if (inputElement.files.length) {
                        updateThumbnail(dropZoneElement, inputElement.files[0]);
                    }
                });

                dropZoneElement.addEventListener("dragover", (e) => {
                    e.preventDefault();
                    dropZoneElement.classList.add("drop-zone--over");
                });

                ["dragleave", "dragend"].forEach((type) => {
                    dropZoneElement.addEventListener(type, (e) => {
                        dropZoneElement.classList.remove("drop-zone--over");
                    });
                });

                dropZoneElement.addEventListener("drop", (e) => {
                    e.preventDefault();

                    if (e.dataTransfer.files.length) {
                        inputElement.files = e.dataTransfer.files;
                        updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                    }

                    dropZoneElement.classList.remove("drop-zone--over");
                });
            });

            /**
             * Updates the thumbnail on a drop zone element.
             *
             * @param {HTMLElement} dropZoneElement
             * @param {File} file
             */
            function updateThumbnail(dropZoneElement, file) {
                let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

                // First time - remove the prompt
                if (dropZoneElement.querySelector(".drop-zone__prompt")) {
                    dropZoneElement.querySelector(".drop-zone__prompt").remove();
                }

                // First time - there is no thumbnail element, so lets create it
                if (!thumbnailElement) {
                    thumbnailElement = document.createElement("div");
                    thumbnailElement.classList.add("drop-zone__thumb");
                    dropZoneElement.appendChild(thumbnailElement);
                }

                //thumbnailElement.dataset.label = file.name;

                // Show thumbnail for image files
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();

                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
                    };
                } else {
                    thumbnailElement.style.backgroundImage = null;
                }
            }

            </script>
            
          <script>
            var room = 1;
            function langkah() {
            
                room++;
                var objTo = document.getElementById('langkah')
                var divtest = document.createElement("div");
                divtest.setAttribute("class", "form-group removeclass"+room);
                var rdiv = 'removeclass'+room;
                divtest.innerHTML = '<div class="form-group"><div class="input-group"><input class="form-control" type="text" placeholder="Default input"> <div class="input-group-btn">  <button class="btn btn-danger" type="button" onclick="remove_langkah('+ room +');"> <span class="glyphicon glyphicon-minus"></span> </button></div></div></div><div class="clear"></div><div class="drop-zone"><span class="drop-zone__prompt">Drop file here or click to upload</span><input type="file" name="myFile" class="drop-zone__input" id="drop-zone-input"></div>';
                
                objTo.appendChild(divtest)
            }
            function remove_langkah(rid) {
                $('.removeclass'+rid).remove();
            }
          </script>



        </div>
        
        {{-- End section 3 --}}
          
        

        
    

    

    <!-- footer -->


    <!-- copyright -->
    <div class="bg-gray-800 py-4">
        <div class="container flex items-center justify-between">
            <p class="text-white">&copy; Humble's Cook's Corp</p>

        </div>
    </div>
    <!-- ./copyright -->
</body>

</html>