<template>
    <div id="app">
      <SideBar />
      <div class="content">
  
        <NationalityIndex/>
        <!-- <main>
          <router-view />
          
        </main> -->
      </div>
    </div>
    
  </template>
  
  <script>

  import SideBar from '@/Components/SideBar.vue';
  import NavBar from '@/Components/NavBar.vue';
  import NationalityIndex from '@/Pages/Nationality/NationalityIndex.vue';
 
  export default {
    name: 'App',
    components: {
      SideBar,
      // NavBar,
      NationalityIndex
    }
  };
  </script>
  
 
  <style>
    #app {
      display: flex;
    }
    .content {
      margin-left: 250px; /* Sidebar width */
      margin-top: 60px; /* Navbar height */
      flex-grow: 1;
    }
    main {
      padding: 1rem;
    }
  </style>
  