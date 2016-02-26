
/**
 * upload image to Maropost media library and update form field
 * with returned asset url
 *
 */
    function addImageToLibrary(key) {
      var imgURL = document.getElementById(key).value;
      console.log(imgURL);

      if (imgURL != '') {
        // if it's already a library image, we're done
        if (imgURL.indexOf('maropost.s3.amazonaws.com') != -1) {
          console.log('[addImageToLibrary] already in library');
          return true;
        }
        else {
          // check if it's an image, in a dumb way
          if (imgURL.toLowerCase().indexOf(".jpg") != -1 ||
              imgURL.toLowerCase().indexOf(".jpeg") != -1 ||
              imgURL.toLowerCase().indexOf(".gif") != -1 ||
              imgURL.toLowerCase().indexOf(".png") != -1) {



            // expecting back a string here
            response=coRegPopup.send('addImageToLibrary.php?imageurl=' + imgURL, '');
            console.info('response:', response);

            if (response.indexOf('maropost.s3.amazonaws.com') != -1) {
              document.getElementById(key).value = response.trim();
              return true;
            }
            // leave the element as-is
            else {
              return true;
            }

          } else {
            console.log("[addImageToLibrary] doesn't appear to be an image");
            return true;
          }
        }
      }
      console.log('[addImageToLibrary]', 'field is empty' );
      return true;
    }
