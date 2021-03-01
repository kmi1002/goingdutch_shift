webpackJsonp([2],{

/***/ 465:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(466);


/***/ }),

/***/ 466:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// // 서비스 워커가 활성화 될 때
// self.addEventListener("activate", event => {
//     // 영구적으로 가져갈 캐시 스트리지 화이트리스트
//     var cacheWhiteList = [PRE_CACHE_NAME, DYNAMIC_CACHE_NAME];
//
//     event.waitUntil(
//         // 캐시 스토리지의 모든 스토리지명을 가져온다.
//         caches.keys().then(cacheNames => {
//             // 캐시를 삭제하는 건 Promise를 반환하므로 Promise.all을 사용해 끝날 시점을 잡아야한다.
//             return Promise.all(
//                 // 이 결과는 [Promise, Promise...] 형태가 되시겠다.
//                 cacheNames.map(cacheName => {
//                     // 각각의 캐시 스토리지명이 화이트 리스트와 같지 않을 경우
//                     if (cacheWhitelist.indexOf(cacheName) === -1) {
//                         // 캐시를 삭제하는 Promise를 배열에 추가한다.
//                         return caches.delete(cacheName);
//                     }
//                 })
//             );
//         })
//     );
//
//     // activate 시에는 clients claim 메소드를 호출해서
//     // 브라우저에 대한 제어권을 가져와야한다.
//     return self.clients.claim();
// });


window.addEventListener('load', function () {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').then(function () {
            console.log('ServiceWorker registered');
        }).catch(function (error) {
            console.warn('ServiceWorker error', error);
        });
    }
});

/***/ })

},[465]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3N3LmpzIl0sIm5hbWVzIjpbIndpbmRvdyIsImFkZEV2ZW50TGlzdGVuZXIiLCJuYXZpZ2F0b3IiLCJzZXJ2aWNlV29ya2VyIiwicmVnaXN0ZXIiLCJ0aGVuIiwiY29uc29sZSIsImxvZyIsImNhdGNoIiwiZXJyb3IiLCJ3YXJuIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBR0FBLE9BQU9DLGdCQUFQLENBQXdCLE1BQXhCLEVBQWdDLFlBQU07QUFDbEMsUUFBSSxtQkFBbUJDLFNBQXZCLEVBQWtDO0FBQzlCQSxrQkFBVUMsYUFBVixDQUF3QkMsUUFBeEIsQ0FBaUMsUUFBakMsRUFDQUMsSUFEQSxDQUNLLFlBQU07QUFDUEMsb0JBQVFDLEdBQVIsQ0FBWSwwQkFBWjtBQUNILFNBSEQsRUFJQUMsS0FKQSxDQUlNLFVBQUNDLEtBQUQsRUFBVztBQUNiSCxvQkFBUUksSUFBUixDQUFhLHFCQUFiLEVBQW9DRCxLQUFwQztBQUNILFNBTkQ7QUFPSDtBQUNKLENBVkQsRSIsImZpbGUiOiIvanMvc3cuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyAvLyDshJzruYTsiqQg7JuM7Luk6rCAIO2ZnOyEse2ZlCDrkKAg65WMXG4vLyBzZWxmLmFkZEV2ZW50TGlzdGVuZXIoXCJhY3RpdmF0ZVwiLCBldmVudCA9PiB7XG4vLyAgICAgLy8g7JiB6rWs7KCB7Jy866GcIOqwgOyguOqwiCDsupDsi5wg7Iqk7Yq466as7KeAIO2ZlOydtO2KuOumrOyKpO2KuFxuLy8gICAgIHZhciBjYWNoZVdoaXRlTGlzdCA9IFtQUkVfQ0FDSEVfTkFNRSwgRFlOQU1JQ19DQUNIRV9OQU1FXTtcbi8vXG4vLyAgICAgZXZlbnQud2FpdFVudGlsKFxuLy8gICAgICAgICAvLyDsupDsi5wg7Iqk7Yag66as7KeA7J2YIOuqqOuToCDsiqTthqDrpqzsp4DrqoXsnYQg6rCA7KC47Jio64ukLlxuLy8gICAgICAgICBjYWNoZXMua2V5cygpLnRoZW4oY2FjaGVOYW1lcyA9PiB7XG4vLyAgICAgICAgICAgICAvLyDsupDsi5zrpbwg7IKt7KCc7ZWY64qUIOqxtCBQcm9taXNl66W8IOuwmO2ZmO2VmOuvgOuhnCBQcm9taXNlLmFsbOydhCDsgqzsmqntlbQg64Gd64KgIOyLnOygkOydhCDsnqHslYTslbztlZzri6QuXG4vLyAgICAgICAgICAgICByZXR1cm4gUHJvbWlzZS5hbGwoXG4vLyAgICAgICAgICAgICAgICAgLy8g7J20IOqysOqzvOuKlCBbUHJvbWlzZSwgUHJvbWlzZS4uLl0g7ZiV7YOc6rCAIOuQmOyLnOqyoOuLpC5cbi8vICAgICAgICAgICAgICAgICBjYWNoZU5hbWVzLm1hcChjYWNoZU5hbWUgPT4ge1xuLy8gICAgICAgICAgICAgICAgICAgICAvLyDqsIHqsIHsnZgg7LqQ7IucIOyKpO2GoOumrOyngOuqheydtCDtmZTsnbTtirgg66as7Iqk7Yq47JmAIOqwmeyngCDslYrsnYQg6rK97JqwXG4vLyAgICAgICAgICAgICAgICAgICAgIGlmIChjYWNoZVdoaXRlbGlzdC5pbmRleE9mKGNhY2hlTmFtZSkgPT09IC0xKSB7XG4vLyAgICAgICAgICAgICAgICAgICAgICAgICAvLyDsupDsi5zrpbwg7IKt7KCc7ZWY64qUIFByb21pc2Xrpbwg67Cw7Je07JeQIOy2lOqwgO2VnOuLpC5cbi8vICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBjYWNoZXMuZGVsZXRlKGNhY2hlTmFtZSk7XG4vLyAgICAgICAgICAgICAgICAgICAgIH1cbi8vICAgICAgICAgICAgICAgICB9KVxuLy8gICAgICAgICAgICAgKTtcbi8vICAgICAgICAgfSlcbi8vICAgICApO1xuLy9cbi8vICAgICAvLyBhY3RpdmF0ZSDsi5zsl5DripQgY2xpZW50cyBjbGFpbSDrqZTshozrk5zrpbwg7Zi47Lac7ZW07IScXG4vLyAgICAgLy8g67iM65287Jqw7KCA7JeQIOuMgO2VnCDsoJzslrTqtozsnYQg6rCA7KC47JmA7JW87ZWc64ukLlxuLy8gICAgIHJldHVybiBzZWxmLmNsaWVudHMuY2xhaW0oKTtcbi8vIH0pO1xuXG5cbndpbmRvdy5hZGRFdmVudExpc3RlbmVyKCdsb2FkJywgKCkgPT4ge1xuICAgIGlmICgnc2VydmljZVdvcmtlcicgaW4gbmF2aWdhdG9yKSB7XG4gICAgICAgIG5hdmlnYXRvci5zZXJ2aWNlV29ya2VyLnJlZ2lzdGVyKCcvc3cuanMnKS5cbiAgICAgICAgdGhlbigoKSA9PiB7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnU2VydmljZVdvcmtlciByZWdpc3RlcmVkJylcbiAgICAgICAgfSkuXG4gICAgICAgIGNhdGNoKChlcnJvcikgPT4ge1xuICAgICAgICAgICAgY29uc29sZS53YXJuKCdTZXJ2aWNlV29ya2VyIGVycm9yJywgZXJyb3IpXG4gICAgICAgIH0pXG4gICAgfVxufSlcblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3N3LmpzIl0sInNvdXJjZVJvb3QiOiIifQ==