const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"user":{"uri":"api\/user","methods":["GET","HEAD"]},"logout":{"uri":"api\/logout","methods":["POST"]},"report":{"uri":"api\/report","methods":["GET","HEAD"]},"category.index":{"uri":"api\/category","methods":["GET","HEAD"]},"category.store":{"uri":"api\/category","methods":["POST"]},"category.show":{"uri":"api\/category\/{category}","methods":["GET","HEAD"],"parameters":["category"]},"category.update":{"uri":"api\/category\/{category}","methods":["PUT","PATCH"],"parameters":["category"]},"category.destroy":{"uri":"api\/category\/{category}","methods":["DELETE"],"parameters":["category"]},"payment.index":{"uri":"api\/payment","methods":["GET","HEAD"]},"payment.store":{"uri":"api\/payment","methods":["POST"]},"payment.show":{"uri":"api\/payment\/{payment}","methods":["GET","HEAD"],"parameters":["payment"]},"payment.update":{"uri":"api\/payment\/{payment}","methods":["PUT","PATCH"],"parameters":["payment"]},"payment.destroy":{"uri":"api\/payment\/{payment}","methods":["DELETE"],"parameters":["payment"],"bindings":{"payment":"id"}},"payment.totalSum":{"uri":"api\/totalSum","methods":["GET","HEAD"]},"payment.getPaymentsByType":{"uri":"api\/paymentsByType","methods":["GET","HEAD"]},"paymentType":{"uri":"api\/paymentType","methods":["GET","HEAD"]},"user_setting.index":{"uri":"api\/user_setting","methods":["GET","HEAD"]},"user_setting.store":{"uri":"api\/user_setting","methods":["POST"]},"login":{"uri":"api\/login","methods":["POST"]},"register":{"uri":"api\/register","methods":["POST"]},"auth.social.callback":{"uri":"api\/auth\/{provider}\/callback","methods":["POST"],"parameters":["provider"]},"exchangeRate":{"uri":"api\/exchangeRate","methods":["GET","HEAD"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };