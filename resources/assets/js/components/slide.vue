<template>
<div class="columns">
  <div class="column is-12">
    <article id="todo" class="message is-link">
      <div class="message-header">
        <p>Imagens</p>      
      </div>
      <div class="message-body">
        <div class="carousel-view">                    
          <transition-group class="carousel" name='fade' tag='div'>
            <div
             v-for="number in [currentNumber]"
             :key='number'
             >
               <img 
                    class="slide" 
                   :src="currentImage"
                   v-on:mouseover="stopRotation"
                   v-on:mouseout="startRotation">
            </div>
          </transition-group>
          <div v-if="this.sources.length == 0">
            <img src="/images/placeholders/sem_foto.png">
          </div>
        </div>
        <div class="flex-center">
          <p>
            <i @click="prev" class="fa fa-arrow-left"></i>  <i @click="next" class="fa fa-arrow-right"></i>
          </p>
        </div>
      </div>    
    </article>
  </div>
</div>  
</template>

<script>
  import res from "../resize.js"
  var images = []

  export default {    
    props:['sources'],
    data() {
      return{
        currentNumber: 0,
        timer: null
      }        
    },

    mounted: function () 
    {
      this.makeArrayImages();
      this.startRotation();        
    },

    methods: {
        startRotation: function() {
          this.timer = setInterval(this.next, 7000);
        },

        stopRotation: function() {
            clearTimeout(this.timer);
            this.timer = null;
        },

        next: function() {
            this.currentNumber += 1
        },
        prev: function() {
            this.currentNumber -= 1
        },
        makeURLResize(fullBase64)
        {
          var resize = new window.resize();
          resize.init();

          resize.resize(fullBase64, 'dataURL', function (imagem) {
              images.push(imagem)              
          },"/images/logos/logo.png")
        },
        makeArrayImages()
        {
          for (var i = 0; i < this.sources.length; i++)
          {
            this.makeURLResize("data:image/"+this.sources.type+";base64, "+this.sources[i].file);
          }
        }
    },
    
    computed: {
      currentImage: function() {
        return images[Math.abs(this.currentNumber) % images.length];
      }
    }
  }
</script>

<style type="text/css">
 
.carousel-view {
  display: flex;
  flex-direction: column;
  align-items: center;

  width: 100%;
  
  overflow: hidden;
  clear: both;
}
.carousel {
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;

  width: auto;
  height: auto;
  position: relative;
}
.slide {
  width: 100%;
  height: auto;
  
}

</style>