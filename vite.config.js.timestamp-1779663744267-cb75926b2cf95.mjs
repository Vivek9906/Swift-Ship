// vite.config.js
import { defineConfig } from "file:///D:/Swift-Ship/node_modules/vite/dist/node/index.js";
import laravel from "file:///D:/Swift-Ship/node_modules/laravel-vite-plugin/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true
    })
  ],
  // ADD THIS: production build output config for Render.com
  build: {
    manifest: true,
    outDir: "public/build",
    rollupOptions: {
      output: {
        manualChunks: void 0
      }
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxTd2lmdC1TaGlwXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJEOlxcXFxTd2lmdC1TaGlwXFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9EOi9Td2lmdC1TaGlwL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XHJcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xyXG5cclxuLy8gRVhJU1RJTkcgQ09ERSBVTkNIQU5HRUQ6IHBsdWdpbnMgYXJyYXkgcHJlc2VydmVkXHJcbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XHJcbiAgcGx1Z2luczogW1xyXG4gICAgbGFyYXZlbCh7XHJcbiAgICAgIGlucHV0OiBbJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsICdyZXNvdXJjZXMvanMvYXBwLmpzJ10sXHJcbiAgICAgIHJlZnJlc2g6IHRydWUsXHJcbiAgICB9KSxcclxuICBdLFxyXG4gIC8vIEFERCBUSElTOiBwcm9kdWN0aW9uIGJ1aWxkIG91dHB1dCBjb25maWcgZm9yIFJlbmRlci5jb21cclxuICBidWlsZDoge1xyXG4gICAgbWFuaWZlc3Q6IHRydWUsXHJcbiAgICBvdXREaXI6ICdwdWJsaWMvYnVpbGQnLFxyXG4gICAgcm9sbHVwT3B0aW9uczoge1xyXG4gICAgICBvdXRwdXQ6IHtcclxuICAgICAgICBtYW51YWxDaHVua3M6IHVuZGVmaW5lZCxcclxuICAgICAgfSxcclxuICAgIH0sXHJcbiAgfSxcclxufSk7XHJcblxyXG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQTZOLFNBQVMsb0JBQW9CO0FBQzFQLE9BQU8sYUFBYTtBQUdwQixJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUMxQixTQUFTO0FBQUEsSUFDUCxRQUFRO0FBQUEsTUFDTixPQUFPLENBQUMseUJBQXlCLHFCQUFxQjtBQUFBLE1BQ3RELFNBQVM7QUFBQSxJQUNYLENBQUM7QUFBQSxFQUNIO0FBQUE7QUFBQSxFQUVBLE9BQU87QUFBQSxJQUNMLFVBQVU7QUFBQSxJQUNWLFFBQVE7QUFBQSxJQUNSLGVBQWU7QUFBQSxNQUNiLFFBQVE7QUFBQSxRQUNOLGNBQWM7QUFBQSxNQUNoQjtBQUFBLElBQ0Y7QUFBQSxFQUNGO0FBQ0YsQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
