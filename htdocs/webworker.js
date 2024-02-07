
var frequency = null

self.onmessage = function(msg){
if(msg.data === 'enableTimeout'){
  enableTimeout()
}else if(msg.data === 'disableTimeout'){
  if(frequency !== null) {
    console.log("Timeout disabled")
    clearTimeout(frequency)
    frequency = null
  }
}
}
function enableTimeout(){
  console.log("Timeout enabled")
  frequency = setTimeout(function(){
    postMessage('logout')
  },6000) // 1 Hour timeout
}
