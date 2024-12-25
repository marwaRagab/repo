
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    async function checkFileAndRedirect(primaryUrl, fallbackUrl) {
        console.log("Checking primary URL:", primaryUrl);

        const primaryReachable = await checkImage(primaryUrl);
        // alert(primaryReachable);
        if (primaryReachable) {
            console.log("Primary URL exists, redirecting...");
            // window.location.href = primaryUrl; // Uncomment to enable redirection
            window.open(primaryUrl, '_blank');
        } else {
            console.log("Primary URL not found, redirecting to fallback...");
            // window.location.href = fallbackUrl; // Uncomment to enable redirection
            window.open(fallbackUrl, '_blank');
            
            
        }
      
    }

    async function checkFileAndPRINT(primaryUrl, fallbackUrl) {

        const primaryReachable = await checkImage(primaryUrl);
        if (primaryReachable) {
            console.log("Primary URL exists, redirecting...");
            // window.location.href = primaryUrl; // Uncomment to enable redirection
            const newWindow = window.open(primaryUrl, '_blank');
            newWindow.onload = () => newWindow.print();
        } else {
            console.log("Primary URL not found, redirecting to fallback...");
            // window.location.href = fallbackUrl; // Uncomment to enable redirection
            const newWindow = window.open(fallbackUrl, '_blank');
            newWindow.onload = () => newWindow.print();
        }


    }

    // function checkImage(url) {
    //    return new Promise((resolve) => {
    //        const img = new Image();
    //        img.onload = () => {
    //            console.log('Image is accessible:', url);
    //            resolve(true);
    //        };
    //        img.onerror = () => {
    //            console.log('Image is not accessible:', url);
    //            resolve(false);
    //        };
    //        img.src = url;
    //    });
    // }

    function checkImage(url) {
        return new Promise((resolve) => {
            // Check file extension
            const extension = url.split('.').pop().toLowerCase();
            // alert(extension);
            
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(extension)) {
                // Check if the URL is a valid image
                const img = new Image();
                img.onload = () => {
                    console.log('The file is an accessible image:', url);
                    resolve(true);
                };
                img.onerror = () => {
                    console.log('The file is not an accessible image:', url);
                    resolve(false);
                };
                img.src = url;
            } else if (extension === 'pdf') {
               
                const substring = "uploads/";
                if (url.includes(substring)) {
                    console.log("The URL contains the substring:", substring);
                    resolve(true);  // URL contains the substring
                } else {
                    console.log("The URL does not contain the substring:", substring);
                    // return false;  // URL does not contain the substring
                    resolve(false);
                }
           
                
            } else {
                console.log('Unknown file type:', url);
                // resolve('unknown');
                resolve(false);
            }
        });
    }
    
    

    



</script>