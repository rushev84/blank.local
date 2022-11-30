// const requestURL = 'https://jsonplaceholder.typicode.com/users'
//
// // console.log('ajax works');
// function sendRequest() {
//     const xhr = new XMLHttpRequest()
//
//     xhr.open('GET', requestURL)
//
//     xhr.responseText = 'json'
//
//     xhr.onload = () => {
//         if (xhr.status >= 400) {
//             console.error(xhr.response)
//         } else {
//             console.log(xhr.response)
//         }
//     }
//
//     xhr.onerror = () => {
//         console.log(xhr.response)
//     }
//
//     xhr.send()
// }