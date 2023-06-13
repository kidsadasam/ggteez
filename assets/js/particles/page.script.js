/**
 * Start Script By EDDGA-STUDIO
 */
particlesJS("particles-js", {
     "particles": {
         "number": {
             "value": 100
             , "density": {
                 "enable": true
                 , "value_area": 3000
             }
         }
         , "color": {
             "value": "#ffffff"
         }
         , "shape": {
             "type": "image",
			 "stroke": {
                 "width": 0
                 , "color": "#000000"
             }
             , "polygon": {
                 "nb_sides": 3
             }
             , "image": {
			"src": ["../images/img1.png","../images/img2.png","../images/img3.png","../images/img4.png","../images/img5.png"],
			"type" : "png",
			"width": 38,
			"height": 38
             }
         }
         , "opacity": {
             "value": 1.0
             , "random": true
             , "anim": {
                 "enable": false
                 , "speed": 1
                 , "opacity_min": 0.1
                 , "sync": false
             }
         }
         , "size": {
             "value": 10
             , "random": false
             , "anim": {
                 "enable": false
                 , "speed": 20
                 , "size_min": 0
                 , "sync": false
             }
         }
         , "line_linked": {
             "enable": false
             , "distance": 500
             , "color": "#ffffff"
             , "opacity": 0.5
             , "width": 3
         }
         , "move": {
             "enable": true
             , "speed": 0.3
             , "direction": "top"
             , "random": true
             , "straight": false
             , "out_mode": "out"
             , "bounce": false
             , "attract": {
                 "enable": false
                 , "rotateX": 600
                 , "rotateY": 1200
             }
         }
     }
     , "interactivity": {
         "detect_on": "canvas"
         , "events": {
             "onhover": {
                 "enable": false
                 , "mode": "bubble"
             }
             , "onclick": {
                 "enable": false
                 , "mode": "repulse"
             }
             , "resize": true
         }
         , "modes": {
             "grab": {
                 "distance": 400
                 , "line_linked": {
                     "opacity": 0.5
                 }
             }
             , "bubble": {
                 "distance": 400
                 , "size": 4
                 , "duration": 0.3
                 , "opacity": 1
                 , "speed": 3
             }
             , "repulse": {
                 "distance": 200
                 , "duration": 0.4
             }
             , "push": {
                 "particles_nb": 4
             }
             , "remove": {
                 "particles_nb": 2
             }
         }
     }
     , "retina_detect": true
 });
/**
* End Script EDDGA-STUDIO
**/
