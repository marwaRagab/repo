<script setup>
import NavBar from './NavBar.vue';
import { CIcon } from '@coreui/icons-vue'; // Import CIcon
import { cilSpeedometer, cilCloudDownload, cilLayers, cilPuzzle } from '@coreui/icons'; // Import specific icons
</script>

<template>
  
  <CSidebar unfoldable colorScheme="dark" class="sidebar" >
    <!-- <CSidebarHeader class="border-bottom"> -->
      <!-- <CSidebarBrand>CUI</CSidebarBrand> -->
      <NavBar></NavBar>
    <!-- </CSidebarHeader> -->
    <CSidebarNav>
      <CNavTitle></CNavTitle>
      <CNavItem href="#">
        <CIcon :icon="cilSpeedometer" class="nav-icon" /> Nav Item
      </CNavItem>
      <CNavItem href="#">
        <CIcon :icon="cilSpeedometer" class="nav-icon" /> With badge
        <CBadge class="ms-auto" color="primary">NEW</CBadge>
      </CNavItem>
      <CNavGroup>
        <template #togglerContent>
          <CIcon :icon="cilPuzzle" class="nav-icon" /> Nav dropdown
        </template>
        <CNavItem href="#">
          <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Nav dropdown item
        </CNavItem>
        <CNavItem href="#">
          <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Nav dropdown item
        </CNavItem>
      </CNavGroup>
      <CNavGroup>
        <template #togglerContent>
          <CIcon :icon="cilPuzzle" class="nav-icon" /> Nav dropdown2
        </template>
        <CNavItem href="#">
          <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Nav dropdown item
        </CNavItem>
        <CNavItem href="#">
          <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Nav dropdown item
        </CNavItem>
      </CNavGroup>
      <CNavItem href="https://coreui.io">
        <CIcon :icon="cilCloudDownload" class="nav-icon" /> Download CoreUI
      </CNavItem>
      <CNavItem href="https://coreui.io/pro/">
        <CIcon :icon="cilLayers" class="nav-icon" /> Try CoreUI PRO
      </CNavItem>
    </CSidebarNav>
  </CSidebar>
</template>

<style>
.sidebar {
  height: 100vh;
margin-top: 5vh;
z-index: -100000;
}
/* Add any custom styling here */
</style>
