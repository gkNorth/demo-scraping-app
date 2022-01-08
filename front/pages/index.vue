<template>
	<div class="item-container">
    <ul class="title-list">
      <li :class="[`tab-${index+1}`, {active: isActiveTab===index+1}]"
          v-for="(site, index) in sites"
          :key="index">
          <a href="#" @click="isActiveTab=index+1">{{ site.site_title }}</a>
      </li>
    </ul>
		<div class="contents-container">
      <div :class="`contents-${index + 1}`"
          v-for="(site, index) in sites"
          :key="`p-${index}`"
          v-show="isActiveTab === index+1">
        <ul class="item-list">
          <li class="item"
              v-for="(item, i) in site.page_titles"
              :key="i">
            <a :href="site.page_links[i]" target="_blank" rel="nofollow noopener noreferrer">{{item}}</a>
          </li>
        </ul>
      </div>
    </div>
	</div>
</template>

<script>
	export default {
		async asyncData({ $axios }) {
			const url = process.env.API_URL; // Add your api url and api key
			const response = await $axios.$get(url);
			return {
				sites: response,
        isActiveTab: 1
			};
		}
	};
</script>

<style lang="scss">
* {
  box-sizing: border-box;
}
body {
  background: #d5d5d5;
}
ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
.title-list {
  display: flex;
  overflow: auto;
  width: 100%;
  li {
    margin-right: 0.3rem;
    min-width: calc(100% / 5);
    a {
      align-items: center;
      background: #43546b;
      border-radius: 10px 10px 0 0;
      color: #fff;
      display: flex;
      justify-content: center;
      min-height: 5rem;
      padding: 0.2rem 0.5rem;
      text-align: center;
      transition: background-color 0.1s;
      width: 100%;
    }
    &.active {
      a {
        background: #284061;
      }
    }
  }
}
.contents-container {
  background: #f5f5f5;
}
.item {
  border-bottom: 1px solid #ccc;
  padding: 1rem;
}
</style>