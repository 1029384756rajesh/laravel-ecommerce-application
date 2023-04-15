
// var lfm = function (selector, options) {
//     const buttons = document.querySelectorAll(selector);

//     buttons.forEach(button => {


//         button.onclick = () => {
//             const targetInput = button.querySelector(button.getAttribute("data-input"))
//             const targetPreview = button.querySelector(button.getAttribute("data-preview"))

//             window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")

//             window.SetUrl = function (items) {

//                 const filePath = items.map(item => item.url).join(",")

//                 // set the value of the desired input to image url
//                 targetInput.value = filePath;
//                 targetInput.dispatchEvent(new Event("change"))

//                 // clear previous preview
//                 targetPreview.src = ""

//                 // set or change the preview image src
//                 items.forEach(function (item) {
//                     // let img = document.createElement('img')
//                     // img.setAttribute('style', 'height: 5rem')
//                     // img.setAttribute('src', item.thumb_url)
//                     // target_preview.appendChild(img);

//                     // $("#imagePreview").attr("src", item.thumb_url)

//                     targetPreview.src = item.thumb_url
//                 })

//                 // trigger change event
//                 targetPreview.dispatchEvent(new Event("change"));
//             }
//         }
//     })

//     $(selector).click(function () {
//         window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")

//         window.SetUrl = function (items) {
//             let filePath = items.map(function (item) {
//                 return item.url;
//             }).join(',');

//             $(this).find("input").val(filePath)
//             // set the value of the desired input to image url
//             target_input.value = file_path;
//             target_input.dispatchEvent(new Event('change'));

//             // clear previous preview
//             target_preview.src = '';

//             // set or change the preview image src
//             items.forEach(function (item) {
//                 // let img = document.createElement('img')
//                 // img.setAttribute('style', 'height: 5rem')
//                 // img.setAttribute('src', item.thumb_url)
//                 // target_preview.appendChild(img);

//                 // $("#imagePreview").attr("src", item.thumb_url)

//                 target_preview.src = item.thumb_url
//             });

//             // trigger change event
//             target_preview.dispatchEvent(new Event('change'));
//         };
//     })
//     button.addEventListener('click', function () {
//         var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
//         var target_input = document.getElementById(button.getAttribute('data-input'));
//         var target_preview = document.getElementById(button.getAttribute('data-preview'));

//         // window.open(route_prefix + '?type=' + options.type || 'file' + '&multiple=true', 'FileManager', 'width=900,height=600');
//         window.open("/laravel-filemanager?type=image&multiple=true", 'FileManager', 'width=900,height=600');
//         window.SetUrl = function (items) {
//             var file_path = items.map(function (item) {
//                 return item.url;
//             }).join(',');

//             // set the value of the desired input to image url
//             target_input.value = file_path;
//             target_input.dispatchEvent(new Event('change'));

//             // clear previous preview
//             target_preview.src = '';

//             // set or change the preview image src
//             items.forEach(function (item) {
//                 // let img = document.createElement('img')
//                 // img.setAttribute('style', 'height: 5rem')
//                 // img.setAttribute('src', item.thumb_url)
//                 // target_preview.appendChild(img);

//                 // $("#imagePreview").attr("src", item.thumb_url)

//                 target_preview.src = item.thumb_url
//             });

//             // trigger change event
//             target_preview.dispatchEvent(new Event('change'));
//         };
//     });
// };

// $("input[id=thumbnail]").change(function () {
//     $("#imagePreview").attr("src", $(this).val())
// })


$(document).ready(function(){

    document.querySelectorAll(".lfm").forEach(button => {

        button.onclick = () => {
    
            const targetInput = button.querySelector(`.${button.getAttribute("data-input")}`)
            const targetPreview = button.querySelector(`.${button.getAttribute("data-preview")}`)
    
            // console.log(targetInput);
            // console.log(targetPreview);
            // return
            window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")
    
            window.SetUrl = function (items) {
    
                const filePath = items.map(item => item.url).join(",")
    
                // set the value of the desired input to image url
                targetInput.value = filePath;
                targetInput.dispatchEvent(new Event("change"))
    
                // clear previous preview
                targetPreview.src = ""
    
                // set or change the preview image src
                items.forEach(function (item) {
                    // let img = document.createElement('img')
                    // img.setAttribute('style', 'height: 5rem')
                    // img.setAttribute('src', item.thumb_url)
                    // target_preview.appendChild(img);
    
                    // $("#imagePreview").attr("src", item.thumb_url)
    
                    targetPreview.src = item.thumb_url
                })
    
                // trigger change event
                targetPreview.dispatchEvent(new Event("change"));
            }
        }
    })
    

})