/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/axios/index.js":
/*!*************************************!*\
  !*** ./node_modules/axios/index.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./lib/axios */ "./node_modules/axios/lib/axios.js");

/***/ }),

/***/ "./node_modules/axios/lib/adapters/xhr.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/adapters/xhr.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var settle = __webpack_require__(/*! ./../core/settle */ "./node_modules/axios/lib/core/settle.js");
var buildURL = __webpack_require__(/*! ./../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
var buildFullPath = __webpack_require__(/*! ../core/buildFullPath */ "./node_modules/axios/lib/core/buildFullPath.js");
var parseHeaders = __webpack_require__(/*! ./../helpers/parseHeaders */ "./node_modules/axios/lib/helpers/parseHeaders.js");
var isURLSameOrigin = __webpack_require__(/*! ./../helpers/isURLSameOrigin */ "./node_modules/axios/lib/helpers/isURLSameOrigin.js");
var createError = __webpack_require__(/*! ../core/createError */ "./node_modules/axios/lib/core/createError.js");

module.exports = function xhrAdapter(config) {
  return new Promise(function dispatchXhrRequest(resolve, reject) {
    var requestData = config.data;
    var requestHeaders = config.headers;

    if (utils.isFormData(requestData)) {
      delete requestHeaders['Content-Type']; // Let the browser set it
    }

    var request = new XMLHttpRequest();

    // HTTP basic authentication
    if (config.auth) {
      var username = config.auth.username || '';
      var password = config.auth.password || '';
      requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
    }

    var fullPath = buildFullPath(config.baseURL, config.url);
    request.open(config.method.toUpperCase(), buildURL(fullPath, config.params, config.paramsSerializer), true);

    // Set the request timeout in MS
    request.timeout = config.timeout;

    // Listen for ready state
    request.onreadystatechange = function handleLoad() {
      if (!request || request.readyState !== 4) {
        return;
      }

      // The request errored out and we didn't get a response, this will be
      // handled by onerror instead
      // With one exception: request that using file: protocol, most browsers
      // will return status as 0 even though it's a successful request
      if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
        return;
      }

      // Prepare the response
      var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
      var responseData = !config.responseType || config.responseType === 'text' ? request.responseText : request.response;
      var response = {
        data: responseData,
        status: request.status,
        statusText: request.statusText,
        headers: responseHeaders,
        config: config,
        request: request
      };

      settle(resolve, reject, response);

      // Clean up request
      request = null;
    };

    // Handle browser request cancellation (as opposed to a manual cancellation)
    request.onabort = function handleAbort() {
      if (!request) {
        return;
      }

      reject(createError('Request aborted', config, 'ECONNABORTED', request));

      // Clean up request
      request = null;
    };

    // Handle low level network errors
    request.onerror = function handleError() {
      // Real errors are hidden from us by the browser
      // onerror should only fire if it's a network error
      reject(createError('Network Error', config, null, request));

      // Clean up request
      request = null;
    };

    // Handle timeout
    request.ontimeout = function handleTimeout() {
      var timeoutErrorMessage = 'timeout of ' + config.timeout + 'ms exceeded';
      if (config.timeoutErrorMessage) {
        timeoutErrorMessage = config.timeoutErrorMessage;
      }
      reject(createError(timeoutErrorMessage, config, 'ECONNABORTED',
        request));

      // Clean up request
      request = null;
    };

    // Add xsrf header
    // This is only done if running in a standard browser environment.
    // Specifically not if we're in a web worker, or react-native.
    if (utils.isStandardBrowserEnv()) {
      var cookies = __webpack_require__(/*! ./../helpers/cookies */ "./node_modules/axios/lib/helpers/cookies.js");

      // Add xsrf header
      var xsrfValue = (config.withCredentials || isURLSameOrigin(fullPath)) && config.xsrfCookieName ?
        cookies.read(config.xsrfCookieName) :
        undefined;

      if (xsrfValue) {
        requestHeaders[config.xsrfHeaderName] = xsrfValue;
      }
    }

    // Add headers to the request
    if ('setRequestHeader' in request) {
      utils.forEach(requestHeaders, function setRequestHeader(val, key) {
        if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
          // Remove Content-Type if data is undefined
          delete requestHeaders[key];
        } else {
          // Otherwise add header to the request
          request.setRequestHeader(key, val);
        }
      });
    }

    // Add withCredentials to request if needed
    if (!utils.isUndefined(config.withCredentials)) {
      request.withCredentials = !!config.withCredentials;
    }

    // Add responseType to request if needed
    if (config.responseType) {
      try {
        request.responseType = config.responseType;
      } catch (e) {
        // Expected DOMException thrown by browsers not compatible XMLHttpRequest Level 2.
        // But, this can be suppressed for 'json' type as it can be parsed by default 'transformResponse' function.
        if (config.responseType !== 'json') {
          throw e;
        }
      }
    }

    // Handle progress if needed
    if (typeof config.onDownloadProgress === 'function') {
      request.addEventListener('progress', config.onDownloadProgress);
    }

    // Not all browsers support upload events
    if (typeof config.onUploadProgress === 'function' && request.upload) {
      request.upload.addEventListener('progress', config.onUploadProgress);
    }

    if (config.cancelToken) {
      // Handle cancellation
      config.cancelToken.promise.then(function onCanceled(cancel) {
        if (!request) {
          return;
        }

        request.abort();
        reject(cancel);
        // Clean up request
        request = null;
      });
    }

    if (requestData === undefined) {
      requestData = null;
    }

    // Send the request
    request.send(requestData);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/axios.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/axios.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");
var Axios = __webpack_require__(/*! ./core/Axios */ "./node_modules/axios/lib/core/Axios.js");
var mergeConfig = __webpack_require__(/*! ./core/mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");
var defaults = __webpack_require__(/*! ./defaults */ "./node_modules/axios/lib/defaults.js");

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {Axios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var context = new Axios(defaultConfig);
  var instance = bind(Axios.prototype.request, context);

  // Copy axios.prototype to instance
  utils.extend(instance, Axios.prototype, context);

  // Copy context to instance
  utils.extend(instance, context);

  return instance;
}

// Create the default instance to be exported
var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
axios.Axios = Axios;

// Factory for creating new instances
axios.create = function create(instanceConfig) {
  return createInstance(mergeConfig(axios.defaults, instanceConfig));
};

// Expose Cancel & CancelToken
axios.Cancel = __webpack_require__(/*! ./cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");
axios.CancelToken = __webpack_require__(/*! ./cancel/CancelToken */ "./node_modules/axios/lib/cancel/CancelToken.js");
axios.isCancel = __webpack_require__(/*! ./cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");

// Expose all/spread
axios.all = function all(promises) {
  return Promise.all(promises);
};
axios.spread = __webpack_require__(/*! ./helpers/spread */ "./node_modules/axios/lib/helpers/spread.js");

module.exports = axios;

// Allow use of default import syntax in TypeScript
module.exports.default = axios;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/Cancel.js":
/*!*************************************************!*\
  !*** ./node_modules/axios/lib/cancel/Cancel.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * A `Cancel` is an object that is thrown when an operation is canceled.
 *
 * @class
 * @param {string=} message The message.
 */
function Cancel(message) {
  this.message = message;
}

Cancel.prototype.toString = function toString() {
  return 'Cancel' + (this.message ? ': ' + this.message : '');
};

Cancel.prototype.__CANCEL__ = true;

module.exports = Cancel;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/CancelToken.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/cancel/CancelToken.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Cancel = __webpack_require__(/*! ./Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @class
 * @param {Function} executor The executor function.
 */
function CancelToken(executor) {
  if (typeof executor !== 'function') {
    throw new TypeError('executor must be a function.');
  }

  var resolvePromise;
  this.promise = new Promise(function promiseExecutor(resolve) {
    resolvePromise = resolve;
  });

  var token = this;
  executor(function cancel(message) {
    if (token.reason) {
      // Cancellation has already been requested
      return;
    }

    token.reason = new Cancel(message);
    resolvePromise(token.reason);
  });
}

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
CancelToken.prototype.throwIfRequested = function throwIfRequested() {
  if (this.reason) {
    throw this.reason;
  }
};

/**
 * Returns an object that contains a new `CancelToken` and a function that, when called,
 * cancels the `CancelToken`.
 */
CancelToken.source = function source() {
  var cancel;
  var token = new CancelToken(function executor(c) {
    cancel = c;
  });
  return {
    token: token,
    cancel: cancel
  };
};

module.exports = CancelToken;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/isCancel.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/cancel/isCancel.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function isCancel(value) {
  return !!(value && value.__CANCEL__);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/Axios.js":
/*!**********************************************!*\
  !*** ./node_modules/axios/lib/core/Axios.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var buildURL = __webpack_require__(/*! ../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
var InterceptorManager = __webpack_require__(/*! ./InterceptorManager */ "./node_modules/axios/lib/core/InterceptorManager.js");
var dispatchRequest = __webpack_require__(/*! ./dispatchRequest */ "./node_modules/axios/lib/core/dispatchRequest.js");
var mergeConfig = __webpack_require__(/*! ./mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");

/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 */
function Axios(instanceConfig) {
  this.defaults = instanceConfig;
  this.interceptors = {
    request: new InterceptorManager(),
    response: new InterceptorManager()
  };
}

/**
 * Dispatch a request
 *
 * @param {Object} config The config specific for this request (merged with this.defaults)
 */
Axios.prototype.request = function request(config) {
  /*eslint no-param-reassign:0*/
  // Allow for axios('example/url'[, config]) a la fetch API
  if (typeof config === 'string') {
    config = arguments[1] || {};
    config.url = arguments[0];
  } else {
    config = config || {};
  }

  config = mergeConfig(this.defaults, config);

  // Set config.method
  if (config.method) {
    config.method = config.method.toLowerCase();
  } else if (this.defaults.method) {
    config.method = this.defaults.method.toLowerCase();
  } else {
    config.method = 'get';
  }

  // Hook up interceptors middleware
  var chain = [dispatchRequest, undefined];
  var promise = Promise.resolve(config);

  this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
    chain.unshift(interceptor.fulfilled, interceptor.rejected);
  });

  this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
    chain.push(interceptor.fulfilled, interceptor.rejected);
  });

  while (chain.length) {
    promise = promise.then(chain.shift(), chain.shift());
  }

  return promise;
};

Axios.prototype.getUri = function getUri(config) {
  config = mergeConfig(this.defaults, config);
  return buildURL(config.url, config.params, config.paramsSerializer).replace(/^\?/, '');
};

// Provide aliases for supported request methods
utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url
    }));
  };
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, data, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url,
      data: data
    }));
  };
});

module.exports = Axios;


/***/ }),

/***/ "./node_modules/axios/lib/core/InterceptorManager.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/core/InterceptorManager.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function InterceptorManager() {
  this.handlers = [];
}

/**
 * Add a new interceptor to the stack
 *
 * @param {Function} fulfilled The function to handle `then` for a `Promise`
 * @param {Function} rejected The function to handle `reject` for a `Promise`
 *
 * @return {Number} An ID used to remove interceptor later
 */
InterceptorManager.prototype.use = function use(fulfilled, rejected) {
  this.handlers.push({
    fulfilled: fulfilled,
    rejected: rejected
  });
  return this.handlers.length - 1;
};

/**
 * Remove an interceptor from the stack
 *
 * @param {Number} id The ID that was returned by `use`
 */
InterceptorManager.prototype.eject = function eject(id) {
  if (this.handlers[id]) {
    this.handlers[id] = null;
  }
};

/**
 * Iterate over all the registered interceptors
 *
 * This method is particularly useful for skipping over any
 * interceptors that may have become `null` calling `eject`.
 *
 * @param {Function} fn The function to call for each interceptor
 */
InterceptorManager.prototype.forEach = function forEach(fn) {
  utils.forEach(this.handlers, function forEachHandler(h) {
    if (h !== null) {
      fn(h);
    }
  });
};

module.exports = InterceptorManager;


/***/ }),

/***/ "./node_modules/axios/lib/core/buildFullPath.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/buildFullPath.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isAbsoluteURL = __webpack_require__(/*! ../helpers/isAbsoluteURL */ "./node_modules/axios/lib/helpers/isAbsoluteURL.js");
var combineURLs = __webpack_require__(/*! ../helpers/combineURLs */ "./node_modules/axios/lib/helpers/combineURLs.js");

/**
 * Creates a new URL by combining the baseURL with the requestedURL,
 * only when the requestedURL is not already an absolute URL.
 * If the requestURL is absolute, this function returns the requestedURL untouched.
 *
 * @param {string} baseURL The base URL
 * @param {string} requestedURL Absolute or relative URL to combine
 * @returns {string} The combined full path
 */
module.exports = function buildFullPath(baseURL, requestedURL) {
  if (baseURL && !isAbsoluteURL(requestedURL)) {
    return combineURLs(baseURL, requestedURL);
  }
  return requestedURL;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/createError.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/createError.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var enhanceError = __webpack_require__(/*! ./enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The created error.
 */
module.exports = function createError(message, config, code, request, response) {
  var error = new Error(message);
  return enhanceError(error, config, code, request, response);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/dispatchRequest.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/core/dispatchRequest.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var transformData = __webpack_require__(/*! ./transformData */ "./node_modules/axios/lib/core/transformData.js");
var isCancel = __webpack_require__(/*! ../cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");
var defaults = __webpack_require__(/*! ../defaults */ "./node_modules/axios/lib/defaults.js");

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
function throwIfCancellationRequested(config) {
  if (config.cancelToken) {
    config.cancelToken.throwIfRequested();
  }
}

/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 * @returns {Promise} The Promise to be fulfilled
 */
module.exports = function dispatchRequest(config) {
  throwIfCancellationRequested(config);

  // Ensure headers exist
  config.headers = config.headers || {};

  // Transform request data
  config.data = transformData(
    config.data,
    config.headers,
    config.transformRequest
  );

  // Flatten headers
  config.headers = utils.merge(
    config.headers.common || {},
    config.headers[config.method] || {},
    config.headers
  );

  utils.forEach(
    ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
    function cleanHeaderConfig(method) {
      delete config.headers[method];
    }
  );

  var adapter = config.adapter || defaults.adapter;

  return adapter(config).then(function onAdapterResolution(response) {
    throwIfCancellationRequested(config);

    // Transform response data
    response.data = transformData(
      response.data,
      response.headers,
      config.transformResponse
    );

    return response;
  }, function onAdapterRejection(reason) {
    if (!isCancel(reason)) {
      throwIfCancellationRequested(config);

      // Transform response data
      if (reason && reason.response) {
        reason.response.data = transformData(
          reason.response.data,
          reason.response.headers,
          config.transformResponse
        );
      }
    }

    return Promise.reject(reason);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/core/enhanceError.js":
/*!*****************************************************!*\
  !*** ./node_modules/axios/lib/core/enhanceError.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Update an Error with the specified config, error code, and response.
 *
 * @param {Error} error The error to update.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The error.
 */
module.exports = function enhanceError(error, config, code, request, response) {
  error.config = config;
  if (code) {
    error.code = code;
  }

  error.request = request;
  error.response = response;
  error.isAxiosError = true;

  error.toJSON = function() {
    return {
      // Standard
      message: this.message,
      name: this.name,
      // Microsoft
      description: this.description,
      number: this.number,
      // Mozilla
      fileName: this.fileName,
      lineNumber: this.lineNumber,
      columnNumber: this.columnNumber,
      stack: this.stack,
      // Axios
      config: this.config,
      code: this.code
    };
  };
  return error;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/mergeConfig.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/mergeConfig.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

/**
 * Config-specific merge-function which creates a new config-object
 * by merging two configuration objects together.
 *
 * @param {Object} config1
 * @param {Object} config2
 * @returns {Object} New object resulting from merging config2 to config1
 */
module.exports = function mergeConfig(config1, config2) {
  // eslint-disable-next-line no-param-reassign
  config2 = config2 || {};
  var config = {};

  var valueFromConfig2Keys = ['url', 'method', 'params', 'data'];
  var mergeDeepPropertiesKeys = ['headers', 'auth', 'proxy'];
  var defaultToConfig2Keys = [
    'baseURL', 'url', 'transformRequest', 'transformResponse', 'paramsSerializer',
    'timeout', 'withCredentials', 'adapter', 'responseType', 'xsrfCookieName',
    'xsrfHeaderName', 'onUploadProgress', 'onDownloadProgress',
    'maxContentLength', 'validateStatus', 'maxRedirects', 'httpAgent',
    'httpsAgent', 'cancelToken', 'socketPath'
  ];

  utils.forEach(valueFromConfig2Keys, function valueFromConfig2(prop) {
    if (typeof config2[prop] !== 'undefined') {
      config[prop] = config2[prop];
    }
  });

  utils.forEach(mergeDeepPropertiesKeys, function mergeDeepProperties(prop) {
    if (utils.isObject(config2[prop])) {
      config[prop] = utils.deepMerge(config1[prop], config2[prop]);
    } else if (typeof config2[prop] !== 'undefined') {
      config[prop] = config2[prop];
    } else if (utils.isObject(config1[prop])) {
      config[prop] = utils.deepMerge(config1[prop]);
    } else if (typeof config1[prop] !== 'undefined') {
      config[prop] = config1[prop];
    }
  });

  utils.forEach(defaultToConfig2Keys, function defaultToConfig2(prop) {
    if (typeof config2[prop] !== 'undefined') {
      config[prop] = config2[prop];
    } else if (typeof config1[prop] !== 'undefined') {
      config[prop] = config1[prop];
    }
  });

  var axiosKeys = valueFromConfig2Keys
    .concat(mergeDeepPropertiesKeys)
    .concat(defaultToConfig2Keys);

  var otherKeys = Object
    .keys(config2)
    .filter(function filterAxiosKeys(key) {
      return axiosKeys.indexOf(key) === -1;
    });

  utils.forEach(otherKeys, function otherKeysDefaultToConfig2(prop) {
    if (typeof config2[prop] !== 'undefined') {
      config[prop] = config2[prop];
    } else if (typeof config1[prop] !== 'undefined') {
      config[prop] = config1[prop];
    }
  });

  return config;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/settle.js":
/*!***********************************************!*\
  !*** ./node_modules/axios/lib/core/settle.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var createError = __webpack_require__(/*! ./createError */ "./node_modules/axios/lib/core/createError.js");

/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 */
module.exports = function settle(resolve, reject, response) {
  var validateStatus = response.config.validateStatus;
  if (!validateStatus || validateStatus(response.status)) {
    resolve(response);
  } else {
    reject(createError(
      'Request failed with status code ' + response.status,
      response.config,
      null,
      response.request,
      response
    ));
  }
};


/***/ }),

/***/ "./node_modules/axios/lib/core/transformData.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/transformData.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

/**
 * Transform the data for a request or a response
 *
 * @param {Object|String} data The data to be transformed
 * @param {Array} headers The headers for the request or response
 * @param {Array|Function} fns A single function or Array of functions
 * @returns {*} The resulting transformed data
 */
module.exports = function transformData(data, headers, fns) {
  /*eslint no-param-reassign:0*/
  utils.forEach(fns, function transform(fn) {
    data = fn(data, headers);
  });

  return data;
};


/***/ }),

/***/ "./node_modules/axios/lib/defaults.js":
/*!********************************************!*\
  !*** ./node_modules/axios/lib/defaults.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {

var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var normalizeHeaderName = __webpack_require__(/*! ./helpers/normalizeHeaderName */ "./node_modules/axios/lib/helpers/normalizeHeaderName.js");

var DEFAULT_CONTENT_TYPE = {
  'Content-Type': 'application/x-www-form-urlencoded'
};

function setContentTypeIfUnset(headers, value) {
  if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
    headers['Content-Type'] = value;
  }
}

function getDefaultAdapter() {
  var adapter;
  if (typeof XMLHttpRequest !== 'undefined') {
    // For browsers use XHR adapter
    adapter = __webpack_require__(/*! ./adapters/xhr */ "./node_modules/axios/lib/adapters/xhr.js");
  } else if (typeof process !== 'undefined' && Object.prototype.toString.call(process) === '[object process]') {
    // For node use HTTP adapter
    adapter = __webpack_require__(/*! ./adapters/http */ "./node_modules/axios/lib/adapters/xhr.js");
  }
  return adapter;
}

var defaults = {
  adapter: getDefaultAdapter(),

  transformRequest: [function transformRequest(data, headers) {
    normalizeHeaderName(headers, 'Accept');
    normalizeHeaderName(headers, 'Content-Type');
    if (utils.isFormData(data) ||
      utils.isArrayBuffer(data) ||
      utils.isBuffer(data) ||
      utils.isStream(data) ||
      utils.isFile(data) ||
      utils.isBlob(data)
    ) {
      return data;
    }
    if (utils.isArrayBufferView(data)) {
      return data.buffer;
    }
    if (utils.isURLSearchParams(data)) {
      setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
      return data.toString();
    }
    if (utils.isObject(data)) {
      setContentTypeIfUnset(headers, 'application/json;charset=utf-8');
      return JSON.stringify(data);
    }
    return data;
  }],

  transformResponse: [function transformResponse(data) {
    /*eslint no-param-reassign:0*/
    if (typeof data === 'string') {
      try {
        data = JSON.parse(data);
      } catch (e) { /* Ignore */ }
    }
    return data;
  }],

  /**
   * A timeout in milliseconds to abort a request. If set to 0 (default) a
   * timeout is not created.
   */
  timeout: 0,

  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',

  maxContentLength: -1,

  validateStatus: function validateStatus(status) {
    return status >= 200 && status < 300;
  }
};

defaults.headers = {
  common: {
    'Accept': 'application/json, text/plain, */*'
  }
};

utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
  defaults.headers[method] = {};
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
});

module.exports = defaults;

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../process/browser.js */ "./node_modules/process/browser.js")))

/***/ }),

/***/ "./node_modules/axios/lib/helpers/bind.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/helpers/bind.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function bind(fn, thisArg) {
  return function wrap() {
    var args = new Array(arguments.length);
    for (var i = 0; i < args.length; i++) {
      args[i] = arguments[i];
    }
    return fn.apply(thisArg, args);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/buildURL.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/helpers/buildURL.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function encode(val) {
  return encodeURIComponent(val).
    replace(/%40/gi, '@').
    replace(/%3A/gi, ':').
    replace(/%24/g, '$').
    replace(/%2C/gi, ',').
    replace(/%20/g, '+').
    replace(/%5B/gi, '[').
    replace(/%5D/gi, ']');
}

/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @returns {string} The formatted url
 */
module.exports = function buildURL(url, params, paramsSerializer) {
  /*eslint no-param-reassign:0*/
  if (!params) {
    return url;
  }

  var serializedParams;
  if (paramsSerializer) {
    serializedParams = paramsSerializer(params);
  } else if (utils.isURLSearchParams(params)) {
    serializedParams = params.toString();
  } else {
    var parts = [];

    utils.forEach(params, function serialize(val, key) {
      if (val === null || typeof val === 'undefined') {
        return;
      }

      if (utils.isArray(val)) {
        key = key + '[]';
      } else {
        val = [val];
      }

      utils.forEach(val, function parseValue(v) {
        if (utils.isDate(v)) {
          v = v.toISOString();
        } else if (utils.isObject(v)) {
          v = JSON.stringify(v);
        }
        parts.push(encode(key) + '=' + encode(v));
      });
    });

    serializedParams = parts.join('&');
  }

  if (serializedParams) {
    var hashmarkIndex = url.indexOf('#');
    if (hashmarkIndex !== -1) {
      url = url.slice(0, hashmarkIndex);
    }

    url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
  }

  return url;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/combineURLs.js":
/*!*******************************************************!*\
  !*** ./node_modules/axios/lib/helpers/combineURLs.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 * @returns {string} The combined URL
 */
module.exports = function combineURLs(baseURL, relativeURL) {
  return relativeURL
    ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
    : baseURL;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/cookies.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/helpers/cookies.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs support document.cookie
    (function standardBrowserEnv() {
      return {
        write: function write(name, value, expires, path, domain, secure) {
          var cookie = [];
          cookie.push(name + '=' + encodeURIComponent(value));

          if (utils.isNumber(expires)) {
            cookie.push('expires=' + new Date(expires).toGMTString());
          }

          if (utils.isString(path)) {
            cookie.push('path=' + path);
          }

          if (utils.isString(domain)) {
            cookie.push('domain=' + domain);
          }

          if (secure === true) {
            cookie.push('secure');
          }

          document.cookie = cookie.join('; ');
        },

        read: function read(name) {
          var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
          return (match ? decodeURIComponent(match[3]) : null);
        },

        remove: function remove(name) {
          this.write(name, '', Date.now() - 86400000);
        }
      };
    })() :

  // Non standard browser env (web workers, react-native) lack needed support.
    (function nonStandardBrowserEnv() {
      return {
        write: function write() {},
        read: function read() { return null; },
        remove: function remove() {}
      };
    })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isAbsoluteURL.js":
/*!*********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isAbsoluteURL.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */
module.exports = function isAbsoluteURL(url) {
  // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
  // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
  // by any combination of letters, digits, plus, period, or hyphen.
  return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isURLSameOrigin.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isURLSameOrigin.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
    (function standardBrowserEnv() {
      var msie = /(msie|trident)/i.test(navigator.userAgent);
      var urlParsingNode = document.createElement('a');
      var originURL;

      /**
    * Parse a URL to discover it's components
    *
    * @param {String} url The URL to be parsed
    * @returns {Object}
    */
      function resolveURL(url) {
        var href = url;

        if (msie) {
        // IE needs attribute set twice to normalize properties
          urlParsingNode.setAttribute('href', href);
          href = urlParsingNode.href;
        }

        urlParsingNode.setAttribute('href', href);

        // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
        return {
          href: urlParsingNode.href,
          protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
          host: urlParsingNode.host,
          search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
          hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
          hostname: urlParsingNode.hostname,
          port: urlParsingNode.port,
          pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
            urlParsingNode.pathname :
            '/' + urlParsingNode.pathname
        };
      }

      originURL = resolveURL(window.location.href);

      /**
    * Determine if a URL shares the same origin as the current location
    *
    * @param {String} requestURL The URL to test
    * @returns {boolean} True if URL shares the same origin, otherwise false
    */
      return function isURLSameOrigin(requestURL) {
        var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
        return (parsed.protocol === originURL.protocol &&
            parsed.host === originURL.host);
      };
    })() :

  // Non standard browser envs (web workers, react-native) lack needed support.
    (function nonStandardBrowserEnv() {
      return function isURLSameOrigin() {
        return true;
      };
    })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/normalizeHeaderName.js":
/*!***************************************************************!*\
  !*** ./node_modules/axios/lib/helpers/normalizeHeaderName.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

module.exports = function normalizeHeaderName(headers, normalizedName) {
  utils.forEach(headers, function processHeader(value, name) {
    if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
      headers[normalizedName] = value;
      delete headers[name];
    }
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/parseHeaders.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/parseHeaders.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// Headers whose duplicates are ignored by node
// c.f. https://nodejs.org/api/http.html#http_message_headers
var ignoreDuplicateOf = [
  'age', 'authorization', 'content-length', 'content-type', 'etag',
  'expires', 'from', 'host', 'if-modified-since', 'if-unmodified-since',
  'last-modified', 'location', 'max-forwards', 'proxy-authorization',
  'referer', 'retry-after', 'user-agent'
];

/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} headers Headers needing to be parsed
 * @returns {Object} Headers parsed into an object
 */
module.exports = function parseHeaders(headers) {
  var parsed = {};
  var key;
  var val;
  var i;

  if (!headers) { return parsed; }

  utils.forEach(headers.split('\n'), function parser(line) {
    i = line.indexOf(':');
    key = utils.trim(line.substr(0, i)).toLowerCase();
    val = utils.trim(line.substr(i + 1));

    if (key) {
      if (parsed[key] && ignoreDuplicateOf.indexOf(key) >= 0) {
        return;
      }
      if (key === 'set-cookie') {
        parsed[key] = (parsed[key] ? parsed[key] : []).concat([val]);
      } else {
        parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
      }
    }
  });

  return parsed;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/spread.js":
/*!**************************************************!*\
  !*** ./node_modules/axios/lib/helpers/spread.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 * @returns {Function}
 */
module.exports = function spread(callback) {
  return function wrap(arr) {
    return callback.apply(null, arr);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/utils.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/utils.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");

/*global toString:true*/

// utils is a library of generic helper functions non-specific to axios

var toString = Object.prototype.toString;

/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Array, otherwise false
 */
function isArray(val) {
  return toString.call(val) === '[object Array]';
}

/**
 * Determine if a value is undefined
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if the value is undefined, otherwise false
 */
function isUndefined(val) {
  return typeof val === 'undefined';
}

/**
 * Determine if a value is a Buffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Buffer, otherwise false
 */
function isBuffer(val) {
  return val !== null && !isUndefined(val) && val.constructor !== null && !isUndefined(val.constructor)
    && typeof val.constructor.isBuffer === 'function' && val.constructor.isBuffer(val);
}

/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */
function isArrayBuffer(val) {
  return toString.call(val) === '[object ArrayBuffer]';
}

/**
 * Determine if a value is a FormData
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an FormData, otherwise false
 */
function isFormData(val) {
  return (typeof FormData !== 'undefined') && (val instanceof FormData);
}

/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */
function isArrayBufferView(val) {
  var result;
  if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
    result = ArrayBuffer.isView(val);
  } else {
    result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
  }
  return result;
}

/**
 * Determine if a value is a String
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a String, otherwise false
 */
function isString(val) {
  return typeof val === 'string';
}

/**
 * Determine if a value is a Number
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Number, otherwise false
 */
function isNumber(val) {
  return typeof val === 'number';
}

/**
 * Determine if a value is an Object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Object, otherwise false
 */
function isObject(val) {
  return val !== null && typeof val === 'object';
}

/**
 * Determine if a value is a Date
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Date, otherwise false
 */
function isDate(val) {
  return toString.call(val) === '[object Date]';
}

/**
 * Determine if a value is a File
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a File, otherwise false
 */
function isFile(val) {
  return toString.call(val) === '[object File]';
}

/**
 * Determine if a value is a Blob
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Blob, otherwise false
 */
function isBlob(val) {
  return toString.call(val) === '[object Blob]';
}

/**
 * Determine if a value is a Function
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */
function isFunction(val) {
  return toString.call(val) === '[object Function]';
}

/**
 * Determine if a value is a Stream
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Stream, otherwise false
 */
function isStream(val) {
  return isObject(val) && isFunction(val.pipe);
}

/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */
function isURLSearchParams(val) {
  return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
}

/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 * @returns {String} The String freed of excess whitespace
 */
function trim(str) {
  return str.replace(/^\s*/, '').replace(/\s*$/, '');
}

/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 * nativescript
 *  navigator.product -> 'NativeScript' or 'NS'
 */
function isStandardBrowserEnv() {
  if (typeof navigator !== 'undefined' && (navigator.product === 'ReactNative' ||
                                           navigator.product === 'NativeScript' ||
                                           navigator.product === 'NS')) {
    return false;
  }
  return (
    typeof window !== 'undefined' &&
    typeof document !== 'undefined'
  );
}

/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 */
function forEach(obj, fn) {
  // Don't bother if no value provided
  if (obj === null || typeof obj === 'undefined') {
    return;
  }

  // Force an array if not already something iterable
  if (typeof obj !== 'object') {
    /*eslint no-param-reassign:0*/
    obj = [obj];
  }

  if (isArray(obj)) {
    // Iterate over array values
    for (var i = 0, l = obj.length; i < l; i++) {
      fn.call(null, obj[i], i, obj);
    }
  } else {
    // Iterate over object keys
    for (var key in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, key)) {
        fn.call(null, obj[key], key, obj);
      }
    }
  }
}

/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function merge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (typeof result[key] === 'object' && typeof val === 'object') {
      result[key] = merge(result[key], val);
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Function equal to merge with the difference being that no reference
 * to original objects is kept.
 *
 * @see merge
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function deepMerge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (typeof result[key] === 'object' && typeof val === 'object') {
      result[key] = deepMerge(result[key], val);
    } else if (typeof val === 'object') {
      result[key] = deepMerge({}, val);
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 * @return {Object} The resulting value of object a
 */
function extend(a, b, thisArg) {
  forEach(b, function assignValue(val, key) {
    if (thisArg && typeof val === 'function') {
      a[key] = bind(val, thisArg);
    } else {
      a[key] = val;
    }
  });
  return a;
}

module.exports = {
  isArray: isArray,
  isArrayBuffer: isArrayBuffer,
  isBuffer: isBuffer,
  isFormData: isFormData,
  isArrayBufferView: isArrayBufferView,
  isString: isString,
  isNumber: isNumber,
  isObject: isObject,
  isUndefined: isUndefined,
  isDate: isDate,
  isFile: isFile,
  isBlob: isBlob,
  isFunction: isFunction,
  isStream: isStream,
  isURLSearchParams: isURLSearchParams,
  isStandardBrowserEnv: isStandardBrowserEnv,
  forEach: forEach,
  merge: merge,
  deepMerge: deepMerge,
  extend: extend,
  trim: trim
};


/***/ }),

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/DateRangePicker.js":
/*!*****************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/DateRangePicker.js ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return DateRangePicker; });
/* harmony import */ var _lib_event_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lib/event.js */ "./node_modules/vanillajs-datepicker/js/lib/event.js");
/* harmony import */ var _lib_date_format_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lib/date-format.js */ "./node_modules/vanillajs-datepicker/js/lib/date-format.js");
/* harmony import */ var _Datepicker_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Datepicker.js */ "./node_modules/vanillajs-datepicker/js/Datepicker.js");




// filter out the config options inapproprite to pass to Datepicker
function filterOptions(options) {
  const newOpts = Object.assign({}, options);

  delete newOpts.inputs;
  delete newOpts.allowOneSidedRange;
  delete newOpts.maxNumberOfDates; // to ensure each datepicker handles a single date

  return newOpts;
}

function setupDatepicker(rangepicker, changeDateListener, el, options) {
  Object(_lib_event_js__WEBPACK_IMPORTED_MODULE_0__["registerListeners"])(rangepicker, [
    [el, 'changeDate', changeDateListener],
  ]);
  return new _Datepicker_js__WEBPACK_IMPORTED_MODULE_2__["default"](el, options, rangepicker);
}

function onChangeDate(rangepicker, ev) {
  // to prevent both datepickers trigger the other side's update each other
  if (rangepicker.updating) {
    return;
  }
  rangepicker.updating = true;

  const target = ev.target;
  if (target.datepicker === undefined) {
    return;
  }

  const datepickers = rangepicker.datepickers;
  const setDateOptions = {render: false};
  const changedSide = rangepicker.inputs.indexOf(target);
  const otherSide = changedSide === 0 ? 1 : 0;
  const changedDate = datepickers[changedSide].dates[0];
  const otherDate = datepickers[otherSide].dates[0];

  if (changedDate !== undefined && otherDate !== undefined) {
    // if the start of the range > the end, swap them
    if (changedSide === 0 && changedDate > otherDate) {
      datepickers[0].setDate(otherDate, setDateOptions);
      datepickers[1].setDate(changedDate, setDateOptions);
    } else if (changedSide === 1 && changedDate < otherDate) {
      datepickers[0].setDate(changedDate, setDateOptions);
      datepickers[1].setDate(otherDate, setDateOptions);
    }
  } else if (!rangepicker.allowOneSidedRange) {
    // to prevent the range from becoming one-sided, copy changed side's
    // selection (no matter if it's empty) to the other side
    if (changedDate !== undefined || otherDate !== undefined) {
      setDateOptions.clear = true;
      datepickers[otherSide].setDate(datepickers[changedSide].dates, setDateOptions);
    }
  }
  datepickers[0].picker.update().render();
  datepickers[1].picker.update().render();
  delete rangepicker.updating;
}

/**
 * Class representing a date range picker
 */
class DateRangePicker  {
  /**
   * Create a date range picker
   * @param  {Element} element - element to bind a date range picker
   * @param  {Object} [options] - config options
   */
  constructor(element, options = {}) {
    const inputs = Array.isArray(options.inputs)
      ? options.inputs
      : Array.from(element.querySelectorAll('input'));
    if (inputs.length < 2) {
      return;
    }

    element.rangepicker = this;
    this.element = element;
    this.inputs = inputs.slice(0, 2);
    this.allowOneSidedRange = !!options.allowOneSidedRange;

    const changeDateListener = onChangeDate.bind(null, this);
    const cleanOptions = filterOptions(options);
    this.datepickers = [
      setupDatepicker(this, changeDateListener, this.inputs[0], cleanOptions),
      setupDatepicker(this, changeDateListener, this.inputs[1], cleanOptions),
    ];
    // normalize the range if inital dates are given
    if (this.dates[0] !== undefined) {
      onChangeDate(this, {target: this.inputs[0]});
    } else if (this.dates[1] !== undefined) {
      onChangeDate(this, {target: this.inputs[1]});
    }
  }

  /**
   * @type {Array} - selected date of the linked date pickers
   */
  get dates() {
    if (this.datepickers) {
      return [
        this.datepickers[0].dates[0],
        this.datepickers[1].dates[0],
      ];
    }
  }

  /**
   * Set new values to the config options
   * @param {Object} options - config options to update
   */
  setOptions(options) {
    this.allowOneSidedRange = !!options.allowOneSidedRange;

    const cleanOptions = filterOptions(options);
    this.datepickers[0].setOptions(cleanOptions);
    this.datepickers[1].setOptions(cleanOptions);
  }

  /**
   * Destroy the DateRangePicker instance
   * @return {DateRangePicker} - the instance destroyed
   */
  destroy() {
    this.datepickers[0].destroy();
    this.datepickers[1].destroy();
    Object(_lib_event_js__WEBPACK_IMPORTED_MODULE_0__["unregisterListeners"])(this);
    delete this.element.rangepicker;
  }

  /**
   * Get the start and end dates of the date range
   *
   * The method returns Date objects by default. If format string is passed,
   * it returns date strings formatted in given format.
   * The result array always contains 2 items (start date/end date) and
   * undifined is used for unselected side. (e.g. If none is selected,
   * the result will be [undifined, undifined]. If only the end date is set
   * when allowOneSidedRange config option is true, [undifined, endDate] will
   * be returned.)
   *
   * @param  {String} [format] - Format string to stringify the dates
   * @return {Array} - Start and end dates
   */
  getDates(format = undefined) {
    const callback = format
      ? date => Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_1__["formatDate"])(date, format, this.datepickers[0].config.locale)
      : date => new Date(date);

    return this.dates.map(date => date === undefined ? date : callback(date));
  }
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/Datepicker.js":
/*!************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/Datepicker.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Datepicker; });
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");
/* harmony import */ var _lib_date_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lib/date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");
/* harmony import */ var _lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./lib/date-format.js */ "./node_modules/vanillajs-datepicker/js/lib/date-format.js");
/* harmony import */ var _lib_event_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./lib/event.js */ "./node_modules/vanillajs-datepicker/js/lib/event.js");
/* harmony import */ var _i18n_base_locales_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./i18n/base-locales.js */ "./node_modules/vanillajs-datepicker/js/i18n/base-locales.js");
/* harmony import */ var _options_defaultOptions_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./options/defaultOptions.js */ "./node_modules/vanillajs-datepicker/js/options/defaultOptions.js");
/* harmony import */ var _options_processOptions_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./options/processOptions.js */ "./node_modules/vanillajs-datepicker/js/options/processOptions.js");
/* harmony import */ var _picker_Picker_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./picker/Picker.js */ "./node_modules/vanillajs-datepicker/js/picker/Picker.js");
/* harmony import */ var _events_functions_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./events/functions.js */ "./node_modules/vanillajs-datepicker/js/events/functions.js");
/* harmony import */ var _events_inputFieldListeners_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./events/inputFieldListeners.js */ "./node_modules/vanillajs-datepicker/js/events/inputFieldListeners.js");
/* harmony import */ var _events_otherListeners_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./events/otherListeners.js */ "./node_modules/vanillajs-datepicker/js/events/otherListeners.js");












function stringifyDates(dates, config) {
  return dates
    .map(dt => Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["formatDate"])(dt, config.format, config.locale))
    .join(config.dateDelimiter);
}

// parse input dates and create an array of time values for selection
// returns undefined if there are no valid dates in inputDates
// when origDates (current selection) is passed, the function works to mix
// the input dates into the current selection
function processInputDates(inputDates, config, origDates = undefined) {
  if (inputDates.length === 0) {
    // empty input is considered valid unless origiDates is passed
    return origDates ? undefined : [];
  }

  let newDates = inputDates.reduce((dates, dt) => {
    const date = Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["parseDate"])(dt, config.format, config.locale);
    if (
      date !== undefined
      && Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["isInRange"])(date, config.minDate, config.maxDate)
      && !dates.includes(date)
      && !config.datesDisabled.includes(date)
      && !config.daysOfWeekDisabled.includes(new Date(date).getDay())
    ) {
      dates.push(date);
    }
    return dates;
  }, []);
  if (newDates.length === 0) {
    return;
  }
  if (origDates && config.multidate) {
    // get the synmetric difference between origDates and newDates
    newDates = newDates.reduce((dates, date) => {
      if (!origDates.includes(date)) {
        dates.push(date);
      }
      return dates;
    }, origDates.filter(date => !newDates.includes(date)));
  }
  // do length check always because user can input multiple dates regardless of the mode
  return config.maxNumberOfDates && newDates.length > config.maxNumberOfDates
    ? newDates.slice(config.maxNumberOfDates * -1)
    : newDates;
}

/**
 * Class representing a date picker
 */
class Datepicker {
  /**
   * Create a date picker
   * @param  {Element} element - element to bind a date picker
   * @param  {Object} [options] - config options
   * @param  {DateRangePicker} [rangepicker] - DateRangePicker instance the
   * date picker belongs to. Use this only when creating date picker as a part
   * of date range picker
   */
  constructor(element, options = {}, rangepicker = undefined) {
    element.datepicker = this;
    this.element = element;

    // set up config
    const config = this.config = Object.assign({
      buttonClass: (options.buttonClass && String(options.buttonClass)) || 'button',
      container: document.body,
      defaultViewDate: Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["today"])(),
      maxDate: undefined,
      minDate: undefined,
    }, Object(_options_processOptions_js__WEBPACK_IMPORTED_MODULE_6__["default"])(_options_defaultOptions_js__WEBPACK_IMPORTED_MODULE_5__["default"], this));
    this._options = options;
    Object.assign(config, Object(_options_processOptions_js__WEBPACK_IMPORTED_MODULE_6__["default"])(options, this));

    // configure by type
    const inline = this.inline = element.tagName !== 'INPUT';
    let inputField;
    let initialDates;

    if (inline) {
      config.container = element;
      initialDates = Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["stringToArray"])(element.dataset.date, config.dateDelimiter);
      delete element.dataset.date;
    } else {
      const container = options.container ? document.querySelector(options.container) : null;
      if (container) {
        config.container = container;
      }
      inputField = this.inputField = element;
      inputField.classList.add('datepicker-input');
      initialDates = Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["stringToArray"])(inputField.value, config.dateDelimiter);
    }
    // set initial value
    this.dates = processInputDates(initialDates, config) || [];

    if (rangepicker && rangepicker.constructor.name === 'DateRangePicker') {
      this.rangepicker = rangepicker;
      // add getter for range
      Object.defineProperty(this, 'range', {
        get() {
          return this.rangepicker.dates;
        },
      });
    }

    const picker = this.picker = new _picker_Picker_js__WEBPACK_IMPORTED_MODULE_7__["default"](this);

    if (inline) {
      this.show();
    } else {
      // set up event listeners in other modes
      const onMousedownDocument = _events_otherListeners_js__WEBPACK_IMPORTED_MODULE_10__["onClickOutside"].bind(null, this);
      const listeners = [
        [inputField, 'keydown', _events_inputFieldListeners_js__WEBPACK_IMPORTED_MODULE_9__["onKeydown"].bind(null, this)],
        [inputField, 'focus', _events_inputFieldListeners_js__WEBPACK_IMPORTED_MODULE_9__["onFocus"].bind(null, this)],
        [inputField, 'mousedown', _events_inputFieldListeners_js__WEBPACK_IMPORTED_MODULE_9__["onMousedown"].bind(null, this)],
        [inputField, 'click', _events_inputFieldListeners_js__WEBPACK_IMPORTED_MODULE_9__["onClickInput"].bind(null, this)],
        [inputField, 'paste', _events_inputFieldListeners_js__WEBPACK_IMPORTED_MODULE_9__["onPaste"].bind(null, this)],
        [document, 'mousedown', onMousedownDocument],
        [document, 'touchstart', onMousedownDocument],
        [window, 'resize', picker.place.bind(picker)]
      ];
      Object(_lib_event_js__WEBPACK_IMPORTED_MODULE_3__["registerListeners"])(this, listeners);
    }
  }

  /**
   * Format Date object or time value in given format and language
   * @param  {Date|Number} date - date or time value to format
   * @param  {String|Object} format - format string or object that contains
   * toDisplay() custom formatter, whose signature is
   * - args:
   *   - date: {Date} - Date instance of the date passed to the method
   *   - format: {Object} - the format object passed to the method
   *   - locale: {Object} - locale for the language specified by `lang`
   * - return:
   *     {String} formatted date
   * @param  {String} [lang=en] - language code for the locale to use
   * @return {String} formatted date
   */
  static formatDate(date, format, lang) {
    return Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["formatDate"])(date, format, lang && _i18n_base_locales_js__WEBPACK_IMPORTED_MODULE_4__["locales"][lang] || _i18n_base_locales_js__WEBPACK_IMPORTED_MODULE_4__["locales"].en);
  }

  /**
   * Pasre date string
   * @param  {String|Date|Number} dateStr - date string, Date object or time
   * value to parse
   * @param  {String|Object} format - format string or object that contains
   * toValue() custom parser, whose signature is
   * - args:
   *   - dateStr: {String|Date|Number} - the dateStr passed to the method
   *   - format: {Object} - the format object passed to the method
   *   - locale: {Object} - locale for the language specified by `lang`
   * - return:
   *     {Date|Number} parsed date or its time value
   * @param  {String} [lang=en] - language code for the locale to use
   * @return {Number} time value of parsed date
   */
  static parseDate(dateStr, format, lang) {
    return Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["parseDate"])(dateStr, format, lang && _i18n_base_locales_js__WEBPACK_IMPORTED_MODULE_4__["locales"][lang] || _i18n_base_locales_js__WEBPACK_IMPORTED_MODULE_4__["locales"].en);
  }

  /**
   * @type {Object} - Installed locales in `[languageCode]: localeObject` format
   * en`:_English (US)_ is pre-installed.
   */
  static get locales() {
    return _i18n_base_locales_js__WEBPACK_IMPORTED_MODULE_4__["locales"];
  }

  /**
   * @type {Boolean} - Whether the picker element is shown. `true` whne shown
   */
  get active() {
    return !!(this.picker && this.picker.active);
  }

  /**
   * Set new values to the config options
   * @param {Object} options - config options to update
   */
  setOptions(options) {
    const picker = this.picker;
    const newOptions = Object(_options_processOptions_js__WEBPACK_IMPORTED_MODULE_6__["default"])(options, this);
    Object.assign(this._options, options);
    Object.assign(this.config, newOptions);
    picker.setOptions(newOptions);

    const currentViewId = picker.currentView.id;
    if (newOptions.maxView < currentViewId) {
      picker.changeView(newOptions.maxView);
    } else if (
      newOptions.startView !== undefined
      && !picker.active
      && newOptions.startView !== currentViewId
    ) {
      picker.changeView(newOptions.startView);
    }

    this.refresh();
  }

  /**
   * Show the picker element
   */
  show() {
    if (this.inputField && this.inputField.disabled) {
      return;
    }
    this.picker.show();
  }

  /**
   * Hide the picker element
   * Not avilable on inline picker
   */
  hide() {
    if (this.inline) {
      return;
    }
    this.picker.hide();
    this.picker.update().changeView(this.config.startView).render();
  }

  /**
   * Destroy the Datepicker instance
   * @return {Detepicker} - the instance destroyed
   */
  destroy() {
    this.hide();
    Object(_lib_event_js__WEBPACK_IMPORTED_MODULE_3__["unregisterListeners"])(this);
    this.picker.detach();
    if (!this.inline) {
      this.inputField.classList.remove('datepicker-input');
    }
    delete this.element.datepicker;
    return this;
  }

  /**
   * Get the selected date(s)
   *
   * The method returns a Date object of selected date by default, and returns
   * an array of selected dates in multidate mode. If format string is passed,
   * it returns date string(s) formatted in given format.
   *
   * @param  {String} [format] - Format string to stringify the date(s)
   * @return {Date|String|Date[]|String[]} - selected date(s), or if none is
   * selected, empty array in multidate mode and untitled in sigledate mode
   */
  getDate(format = undefined) {
    const callback = format
      ? date => Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["formatDate"])(date, format, this.config.locale)
      : date => new Date(date);

    if (this.config.multidate) {
      return this.dates.map(callback);
    }
    if (this.dates.length > 0) {
      return callback(this.dates[0]);
    }
  }

  /**
   * Set selected date(s)
   *
   * In multidate mode, you can pass multiple dates as a series of arguments
   * or an array. (Since each date is parsed individually, the type of the
   * dates doesn't have to be the same.)
   * The given dates are used to toggle the select status of each date. The
   * number of selected dates is kept from exceeding the length set to
   * maxNumberOfDates.
   *
   * With clear: true option, the method can be used to clear the selection
   * and to replace the selection instead of toggling in multidate mode.
   * If the option is passed with no date arguments or an empty dates array,
   * it works as "clear" (clear the selection then set nothing), and if the
   * option is passed with new dates to select, it works as "replace" (clear
   * the selection then set the given dates)
   *
   * When render: false option is used, the method omits re-rendering the
   * picker element. In this case, you need to call refresh() method later in
   * order for the picker element to reflect the changes. The input field is
   * refreshed always regardless of this option.
   *
   * When invalid (unparsable, repeated, disabled or out-of-range) dates are
   * passed, the method ignores them and applies only valid ones. In the case
   * that all the given dates are invalid, which is distiguished from passing
   * no dates, the method considers it as an error and leaves the selection
   * untouched.
   *
   * @param {...(Date|Number|String)|Array} [dates] - Date strings, Date
   * objects, time values or mix of those for new selection
   * @param {Object} [options] - function options
   * - clear: {boolean} - Whether to clear the existing selection
   *     defualt: false
   * - render: {boolean} - Whether to re-render the picker element
   *     default: true
   * - autohide: {boolean} - Whether to hide the picker element after re-render
   *     Ignored when used with render: false
   *     default: config.autohide
   */
  setDate(...args) {
    const dates = [...args];
    const opts = {clear: false, render: true, autohide: this.config.autohide};
    const lastArg = Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["lastItemOf"])(args);
    if (
      typeof lastArg === 'object'
      && !Array.isArray(lastArg)
      && !(lastArg instanceof Date)
    ) {
      Object.assign(opts, dates.pop());
    }

    const inputDates = Array.isArray(dates[0]) ? dates[0] : dates;
    const origDates = opts.clear ? undefined : this.dates;
    const newDates = processInputDates(inputDates, this.config, origDates);
    if (!newDates) {
      return;
    }
    if (newDates.toString() !== this.dates.toString()) {
      this.dates = newDates;
      if (opts.render) {
        this.picker.update();
        this.refresh();
      } else {
        this.refresh('input');
      }
      Object(_events_functions_js__WEBPACK_IMPORTED_MODULE_8__["triggerDatepickerEvent"])(this, 'changeDate');
    } else {
      this.refresh('input');
    }
    if (opts.render && opts.autohide) {
      this.hide();
    }
  }

  /**
   * Update the selected date(s) with input field's value
   * Not avilable on inline picker
   *
   * The input field will be refreshed with properly formatted date string.
   *
   * @param  {Object} [options] - function options
   * - autohide: {boolean} - whether to hide the picker element after refresh
   *     default: false
   */
  update(options = undefined) {
    if (this.inline) {
      return;
    }

    const opts = Object.assign({autohide: false}, options);
    const inputDates = Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["stringToArray"])(this.inputField.value, this.config.dateDelimiter);
    const newDates = processInputDates(inputDates, this.config);
    if (!newDates) {
      return;
    }
    if (newDates.toString() !== this.dates.toString()) {
      this.dates = newDates;
      this.picker.update();
      this.refresh();
      Object(_events_functions_js__WEBPACK_IMPORTED_MODULE_8__["triggerDatepickerEvent"])(this, 'changeDate');
    } else {
      this.refresh('input');
    }
    if (opts.autohide) {
      this.hide();
    }
  }

  /**
   * Refresh the picker element and the associated input field
   * @param {String} [target] - target item when refreshing one item only
   * 'picker' or 'input'
   */
  refresh(target = undefined) {
    if (target !== 'input') {
      this.picker.render();
    }
    if (!this.inline && target !== 'picker') {
      this.inputField.value = stringifyDates(this.dates, this.config);
    }
  }

  /**
   * Enter edit mode
   * Not avilable on inline picker or when the picker element is hidden
   */
  enterEditMode() {
    if (this.inline || !this.picker.active || this.editMode) {
      return;
    }
    this.editMode = true;
    this.inputField.classList.add('in-edit');
  }

  /**
   * Exit from edit mode
   * Not avilable on inline picker
   * @param  {Object} [options] - function options
   * - update: {boolean} - whether to call update() after exiting
   *     If false, input field is revert to the existing selection
   *     default: false
   */
  exitEditMode(options = undefined) {
    if (this.inline || !this.editMode) {
      return;
    }
    const opts = Object.assign({update: false}, options);
    delete this.editMode;
    this.inputField.classList.remove('in-edit');
    if (opts.update) {
      this.update(opts);
    } else {
      this.inputField.value = stringifyDates(this.dates, this.config);
    }
  }
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/events/functions.js":
/*!******************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/events/functions.js ***!
  \******************************************************************/
/*! exports provided: triggerDatepickerEvent, goToPrevOrNext, switchView */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "triggerDatepickerEvent", function() { return triggerDatepickerEvent; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "goToPrevOrNext", function() { return goToPrevOrNext; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "switchView", function() { return switchView; });
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");
/* harmony import */ var _lib_date_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../lib/date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");



function triggerDatepickerEvent(datepicker, type) {
  const detail = {
    date: datepicker.getDate(),
    viewDate: new Date(datepicker.picker.viewDate),
    viewId: datepicker.picker.currentView.id,
    datepicker,
  };
  datepicker.element.dispatchEvent(new CustomEvent(type, {detail}));
}

// direction: -1 (to previous), 1 (to next)
function goToPrevOrNext(datepicker, direction) {
  const {minDate, maxDate} = datepicker.config;
  const {currentView, viewDate} = datepicker.picker;
  let newViewDate;
  switch (currentView.id) {
    case 0:
      newViewDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addMonths"])(viewDate, direction);
      break;
    case 1:
      newViewDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addYears"])(viewDate, direction);
      break;
    default:
      newViewDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addYears"])(viewDate, direction * currentView.navStep);
  }
  newViewDate = Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["limitToRange"])(newViewDate, minDate, maxDate);
  datepicker.picker.changeFocus(newViewDate).render();
}

function switchView(datepicker) {
  const viewId = datepicker.picker.currentView.id;
  if (viewId === datepicker.config.maxView) {
    return;
  }
  datepicker.picker.changeView(viewId + 1).render();
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/events/inputFieldListeners.js":
/*!****************************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/events/inputFieldListeners.js ***!
  \****************************************************************************/
/*! exports provided: onKeydown, onFocus, onMousedown, onClickInput, onPaste */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onKeydown", function() { return onKeydown; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onFocus", function() { return onFocus; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onMousedown", function() { return onMousedown; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onClickInput", function() { return onClickInput; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onPaste", function() { return onPaste; });
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");
/* harmony import */ var _lib_date_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../lib/date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");
/* harmony import */ var _functions_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./functions.js */ "./node_modules/vanillajs-datepicker/js/events/functions.js");




// Find the closest date that doesn't meet the condition for unavailable date
// Returns undefined if no available date is found
// addFn: function to calculate the next date
//   - args: time value, amount
// increase: amount to pass to addFn
// testFn: function to test the unavailablity of the date
//   - args: time value; retun: true if unavailable
function findNextAvailableOne(date, addFn, increase, testFn, min, max) {
  if (!Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["isInRange"])(date, min, max)) {
    return;
  }
  if (testFn(date)) {
    const newDate = addFn(date, increase);
    return findNextAvailableOne(newDate, addFn, increase, testFn, min, max);
  }
  return date;
}

// direction: -1 (left/up), 1 (right/down)
// vertical: true for up/down, false for left/right
function moveByArrowKey(datepicker, ev, direction, vertical) {
  const currentView = datepicker.picker.currentView;
  const step = currentView.step || 1;
  let viewDate = datepicker.picker.viewDate;
  let addFn;
  let testFn;
  switch (currentView.id) {
    case 0:
      if (vertical) {
        viewDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addDays"])(viewDate, direction * 7);
      } else if (ev.ctrlKey || ev.metaKey) {
        viewDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addYears"])(viewDate, direction);
      } else {
        viewDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addDays"])(viewDate, direction);
      }
      addFn = _lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addDays"];
      testFn = (date) => currentView.disabled.includes(date);
      break;
    case 1:
      viewDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addMonths"])(viewDate, vertical ? direction * 4 : direction);
      addFn = _lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addMonths"];
      testFn = (date) => {
        const dt = new Date(date);
        const {year, disabled} = currentView;
        return dt.getFullYear() === year && disabled.includes(dt.getMonth());
      };
      break;
    default:
      viewDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addYears"])(viewDate, direction * (vertical ? 4 : 1) * step);
      addFn = _lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addYears"];
      testFn = date => currentView.disabled.includes(Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["startOfYearPeriod"])(date, step));
  }
  viewDate = findNextAvailableOne(
    viewDate,
    addFn,
    direction < 0 ? -step : step,
    testFn,
    currentView.minDate,
    currentView.maxDate
  );
  if (viewDate !== undefined) {
    datepicker.picker.changeFocus(viewDate).render();
  }
}

function onKeydown(datepicker, ev) {
  if (ev.key === 'Tab') {
    datepicker.refresh('input');
    datepicker.hide();
    return;
  }

  const viewId = datepicker.picker.currentView.id;
  if (!datepicker.picker.active) {
    switch (ev.key) {
      case 'ArrowDown':
      case 'Escape':
        datepicker.picker.show();
        break;
      case 'Enter':
        datepicker.update();
        break;
      default:
        return;
    }
  } else if (datepicker.editMode) {
    switch (ev.key) {
      case 'Escape':
        datepicker.exitEditMode();
        break;
      case 'Enter':
        datepicker.exitEditMode({update: true, autohide: datepicker.config.autohide});
        break;
      default:
        return;
    }
  } else {
    switch (ev.key) {
      case 'Escape':
        if (ev.shiftKey) {
          datepicker.enterEditMode();
        } else {
          datepicker.picker.hide();
        }
        break;
      case 'ArrowLeft':
        if (ev.ctrlKey || ev.metaKey) {
          Object(_functions_js__WEBPACK_IMPORTED_MODULE_2__["goToPrevOrNext"])(datepicker, -1);
        } else {
          moveByArrowKey(datepicker, ev, -1, false);
        }
        break;
      case 'ArrowRight':
        if (ev.ctrlKey || ev.metaKey) {
          Object(_functions_js__WEBPACK_IMPORTED_MODULE_2__["goToPrevOrNext"])(datepicker, 1);
        } else {
          moveByArrowKey(datepicker, ev, 1, false);
        }
        break;
      case 'ArrowUp':
        if (ev.ctrlKey || ev.metaKey) {
          Object(_functions_js__WEBPACK_IMPORTED_MODULE_2__["switchView"])(datepicker);
        } else {
          moveByArrowKey(datepicker, ev, -1, true);
        }
        break;
      case 'ArrowDown':
        moveByArrowKey(datepicker, ev, 1, true);
        break;
      case 'Enter':
        if (viewId === 0) {
          datepicker.setDate(datepicker.picker.viewDate);
        } else {
          datepicker.picker.changeView(viewId - 1).render();
        }
        break;
      case 'Backspace':
      case 'Delete':
        datepicker.enterEditMode();
        return;
      default:
        if (ev.key.length === 1 && !ev.ctrlKey && !ev.metaKey) {
          datepicker.enterEditMode();
        }
        return;
    }
  }
  ev.preventDefault();
  ev.stopPropagation();
}

function onFocus(datepicker) {
  if (datepicker.config.showOnFocus) {
    datepicker.show();
  }
}

// for the prevention for entering edit mode while getting focus on click
function onMousedown(datepicker, ev) {
  const el = ev.target;
  if (datepicker.picker.active) {
    el._clicking = setTimeout(() => {
      delete el._clicking;
    }, 2000);
  }
}

function onClickInput(datepicker, ev) {
  const el = ev.target;
  if (!el._clicking) {
    return;
  }
  clearTimeout(el._clicking);
  delete el._clicking;

  datepicker.enterEditMode();
}

function onPaste(datepicker, ev) {
  if (ev.clipboardData.types.includes('text/plain')) {
    datepicker.enterEditMode();
  }
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/events/otherListeners.js":
/*!***********************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/events/otherListeners.js ***!
  \***********************************************************************/
/*! exports provided: onClickOutside */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onClickOutside", function() { return onClickOutside; });
/* harmony import */ var _lib_event_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../lib/event.js */ "./node_modules/vanillajs-datepicker/js/lib/event.js");


// for the `document` to delegate the events from outside the picker/input field
function onClickOutside(datepicker, ev) {
  const element = datepicker.element;
  const pickerElem = datepicker.picker.element;

  if (Object(_lib_event_js__WEBPACK_IMPORTED_MODULE_0__["findElementInEventPath"])(ev, el => el === element || el === pickerElem)) {
    return;
  }
  datepicker.refresh('input');
  datepicker.hide();
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/events/pickerListeners.js":
/*!************************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/events/pickerListeners.js ***!
  \************************************************************************/
/*! exports provided: onClickTodayBtn, onClickClearBtn, onClickViewSwitch, onClickPrevBtn, onClickNextBtn, onClickView, onClickPicker */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onClickTodayBtn", function() { return onClickTodayBtn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onClickClearBtn", function() { return onClickClearBtn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onClickViewSwitch", function() { return onClickViewSwitch; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onClickPrevBtn", function() { return onClickPrevBtn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onClickNextBtn", function() { return onClickNextBtn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onClickView", function() { return onClickView; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onClickPicker", function() { return onClickPicker; });
/* harmony import */ var _lib_date_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../lib/date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");
/* harmony import */ var _lib_event_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../lib/event.js */ "./node_modules/vanillajs-datepicker/js/lib/event.js");
/* harmony import */ var _functions_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./functions.js */ "./node_modules/vanillajs-datepicker/js/events/functions.js");




function goToSelectedMonthOrYear(datepicker, selection) {
  const picker = datepicker.picker;
  const viewDate = new Date(picker.viewDate);
  const viewId = picker.currentView.id;
  const newDate = viewId === 1
    ? Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_0__["addMonths"])(viewDate, selection - viewDate.getMonth())
    : Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_0__["addYears"])(viewDate, selection - viewDate.getFullYear());

  picker.changeFocus(newDate).changeView(viewId - 1).render();
}

function onClickTodayBtn(datepicker) {
  const picker = datepicker.picker;
  const currentDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_0__["today"])();
  if (datepicker.config.todayBtnMode === 1) {
    if (datepicker.config.autohide) {
      datepicker.setDate(currentDate);
      return;
    }
    datepicker.setDate(currentDate, {render: false});
    picker.update();
  }
  if (picker.viewDate !== currentDate) {
    picker.changeFocus(currentDate);
  }
  picker.changeView(0).render();
}

function onClickClearBtn(datepicker) {
  datepicker.setDate({clear: true});
}

function onClickViewSwitch(datepicker) {
  Object(_functions_js__WEBPACK_IMPORTED_MODULE_2__["switchView"])(datepicker);
}

function onClickPrevBtn(datepicker) {
  Object(_functions_js__WEBPACK_IMPORTED_MODULE_2__["goToPrevOrNext"])(datepicker, -1);
}

function onClickNextBtn(datepicker) {
  Object(_functions_js__WEBPACK_IMPORTED_MODULE_2__["goToPrevOrNext"])(datepicker, 1);
}

// For the picker's main block to delegete the events from `datepicker-cell`s
function onClickView(datepicker, ev) {
  const target = Object(_lib_event_js__WEBPACK_IMPORTED_MODULE_1__["findElementInEventPath"])(ev, '.datepicker-cell');
  if (!target || target.classList.contains('disabled')) {
    return;
  }

  switch (datepicker.picker.currentView.id) {
    case 0:
      datepicker.setDate(Number(target.dataset.date));
      break;
    case 1:
      goToSelectedMonthOrYear(datepicker, Number(target.dataset.month));
      break;
    default:
      goToSelectedMonthOrYear(datepicker, Number(target.dataset.year));
  }
}

function onClickPicker(datepicker, ev) {
  ev.preventDefault();
  ev.stopPropagation();

  // check if the picker is active in order to prevent the picker from being
  // re-shown after auto-hide when showOnFocus: true
  // it's caused by bubbled event from cells/buttons, but the bubbling cannot
  // be disabled because it's needed to keep the focus on the input element
  if (!datepicker.inline && datepicker.picker.active && !datepicker.config.disableTouchKeyboard) {
    datepicker.inputField.focus();
  }
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/i18n/base-locales.js":
/*!*******************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/i18n/base-locales.js ***!
  \*******************************************************************/
/*! exports provided: locales */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "locales", function() { return locales; });
// default locales
const locales = {
  en: {
    days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
    daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
    months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    today: "Today",
    clear: "Clear",
    titleFormat: "MM y"
  }
};


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/i18n/locales/ru.js":
/*!*****************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/i18n/locales/ru.js ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/**
 * Russian translation for bootstrap-datepicker
 * Victor Taranenko <darwin@snowdale.com>
 */
/* harmony default export */ __webpack_exports__["default"] = ({
  ru: {
    days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
    daysShort: ["Вск", "Пнд", "Втр", "Срд", "Чтв", "Птн", "Суб"],
    daysMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
    months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
    monthsShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
    today: "Сегодня",
    clear: "Очистить",
    format: "dd.mm.yyyy",
    weekStart: 1,
    monthsTitle: 'Месяцы'
  }
});


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/lib/date-format.js":
/*!*****************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/lib/date-format.js ***!
  \*****************************************************************/
/*! exports provided: reFormatTokens, reNonDateParts, parseDate, formatDate */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "reFormatTokens", function() { return reFormatTokens; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "reNonDateParts", function() { return reNonDateParts; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parseDate", function() { return parseDate; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "formatDate", function() { return formatDate; });
/* harmony import */ var _date_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");



// pattern for format parts
const reFormatTokens = /dd?|DD?|mm?|MM?|yy?(?:yy)?/;
// pattern for non date parts
const reNonDateParts = /[\s!-/:-@[-`{-~年月日]+/;
// cache for persed formats
let knownFormats = {};
// parse funtions for date parts
const parseFns = {
  y(date, year) {
    return new Date(date).setFullYear(parseInt(year, 10));
  },
  M: undefined,  // placeholder to maintain the key order
  m(date, month, locale) {
    const newDate = new Date(date);
    let monthIndex = parseInt(month, 10) - 1;

    if (isNaN(monthIndex)) {
      if (!month) {
        return NaN;
      }

      const monthName = month.toLowerCase();
      const compareNames = name => name.toLowerCase().startsWith(monthName);
      // compare with both short and full names because some locales have periods
      // in the short names (not equal to the first X letters of the full names)
      monthIndex = locale.monthsShort.findIndex(compareNames);
      if (monthIndex < 0) {
        monthIndex = locale.months.findIndex(compareNames);
      }
      return monthIndex < 0 ? NaN : newDate.setMonth(monthIndex);
    }

    newDate.setMonth(monthIndex);
    return newDate.getMonth() !== normalizeMonth(monthIndex)
      ? newDate.setDate(0)
      : newDate.getTime();
  },
  d(date, day) {
    return new Date(date).setDate(parseInt(day, 10));
  },
};
parseFns.M = parseFns.m;  // make "M" an alias of "m"
// format functions for date parts
const formatFns = {
  d(date) {
    return date.getDate();
  },
  dd(date) {
    return padZero(date.getDate(), 2);
  },
  D(date, locale) {
    return locale.daysShort[date.getDay()];
  },
  DD(date, locale) {
    return locale.days[date.getDay()];
  },
  m(date) {
    return date.getMonth() + 1;
  },
  mm(date) {
    return padZero(date.getMonth() + 1, 2);
  },
  M(date, locale) {
    return locale.monthsShort[date.getMonth()];
  },
  MM(date, locale) {
    return locale.months[date.getMonth()];
  },
  y(date) {
    return date.getFullYear();
  },
  yy(date) {
    return padZero(date.getFullYear(), 2).slice(-2);
  },
  yyyy(date) {
    return padZero(date.getFullYear(), 4);
  },
};

// get month index in normal range (0 - 11) from any number
function normalizeMonth(monthIndex) {
  return monthIndex > -1 ? monthIndex % 12 : normalizeMonth(monthIndex + 12);
}

function padZero(num, length) {
  return num.toString().padStart(length, '0');
}

function parseFormatString(format) {
  if (typeof format !== 'string') {
    throw new Error("Invalid date format.");
  }
  if (format in knownFormats) {
    return knownFormats[format];
  }

  // sprit the format string into parts and seprators
  const separators = format.split(reFormatTokens);
  const parts = format.match(new RegExp(reFormatTokens, 'g'));
  if (separators.length === 0 || !parts) {
    throw new Error("Invalid date format.");
  }

  // collect format functions used in the format
  const partFormatters = parts.map(token => formatFns[token]);

  // collect parse functions used in the format
  // iterate over parseFns' keys in order to keep the order of the keys.
  const partParsers = Object.keys(parseFns).reduce((parsers, key) => {
    const token = parts.find(part => part[0] === key);
    if (!token) {
      return parsers;
    }
    parsers[key] = parseFns[key];
    return parsers;
  }, {});
  const partParserKeys = Object.keys(partParsers);

  return knownFormats[format] = {
    parser(dateStr, locale) {
      const dateParts = dateStr.split(reNonDateParts).reduce((dtParts, part, index) => {
        if (part.length > 0 && parts[index]) {
          const token = parts[index][0];
          if (parseFns[token] !== undefined) {
            dtParts[token] = part;
          }
        }
        return dtParts;
      }, {});

      // iterate over partParsers' keys so that the parsing is made in the oder
      // of year, month and day to prevent the day parser from correcting last
      // day of month wrongly
      return partParserKeys.reduce((origDate, key) => {
        const newDate = partParsers[key](origDate, dateParts[key], locale);
        // ingnore the part failed to parse
        return isNaN(newDate) ? origDate : newDate;
      }, Object(_date_js__WEBPACK_IMPORTED_MODULE_0__["today"])());
    },
    formatter(date, locale) {
      let dateStr = partFormatters.reduce((str, fn, index) => {
        return str += `${separators[index]}${fn(date, locale)}`;
      }, '');
      // separators' length is always parts' length + 1,
      return dateStr += Object(_utils_js__WEBPACK_IMPORTED_MODULE_1__["lastItemOf"])(separators);
    },
  };
}

function parseDate(dateStr, format, locale) {
  if (dateStr instanceof Date || typeof dateStr === 'number') {
    const date = Object(_date_js__WEBPACK_IMPORTED_MODULE_0__["stripTime"])(dateStr);
    return isNaN(date) ? undefined : date;
  }
  if (!dateStr) {
    return undefined;
  }
  if (dateStr === 'today') {
    return Object(_date_js__WEBPACK_IMPORTED_MODULE_0__["today"])();
  }

  if (format && format.toValue) {
    const date = format.toValue(dateStr, format, locale);
    return isNaN(date) ? undefined : Object(_date_js__WEBPACK_IMPORTED_MODULE_0__["stripTime"])(date);
  }

  return parseFormatString(format).parser(dateStr, locale);
}

function formatDate(date, format, locale) {
  if (isNaN(date) || (!date && date !== 0)) {
    return '';
  }

  const dateObj = typeof date === 'number' ? new Date(date) : date;

  if (format.toDisplay) {
    return format.toDisplay(dateObj, format, locale);
  }

  return parseFormatString(format).formatter(dateObj, locale);
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/lib/date.js":
/*!**********************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/lib/date.js ***!
  \**********************************************************/
/*! exports provided: stripTime, today, dateValue, addDays, addWeeks, addMonths, addYears, dayOfTheWeekOf, getWeek, startOfYearPeriod */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "stripTime", function() { return stripTime; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "today", function() { return today; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "dateValue", function() { return dateValue; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addDays", function() { return addDays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addWeeks", function() { return addWeeks; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addMonths", function() { return addMonths; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addYears", function() { return addYears; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "dayOfTheWeekOf", function() { return dayOfTheWeekOf; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getWeek", function() { return getWeek; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "startOfYearPeriod", function() { return startOfYearPeriod; });
function stripTime(timeValue) {
  return new Date(timeValue).setHours(0, 0, 0, 0);
}

function today() {
  return new Date().setHours(0, 0, 0, 0);
}

// Get the time value of the start of given date or year, month and day
function dateValue(...args) {
  switch (args.length) {
    case 0:
      return today();
    case 1:
      return stripTime(args[0]);
  }

  // use setFullYear() to keep 2-digit year from being mapped to 1900-1999
  const newDate = new Date(0);
  newDate.setFullYear(...args);
  return newDate.setHours(0, 0, 0, 0);
}

function addDays(date, amount) {
  const newDate = new Date(date);
  return newDate.setDate(newDate.getDate() + amount);
}

function addWeeks(date, amount) {
  return addDays(date, amount * 7);
}

function addMonths(date, amount) {
  // If the day of the date is not in the new month, the last day of the new
  // month will be returned. e.g. Jan 31 + 1 month → Feb 28 (not Mar 03)
  const newDate = new Date(date);
  const monthsToSet = newDate.getMonth() + amount;
  let expectedMonth = monthsToSet % 12;
  if (expectedMonth < 0) {
    expectedMonth += 12;
  }

  const time = newDate.setMonth(monthsToSet);
  return newDate.getMonth() !== expectedMonth ? newDate.setDate(0) : time;
}

function addYears(date, amount) {
  // If the date is Feb 29 and the new year is not a leap year, Feb 28 of the
  // new year will be returned.
  const newDate = new Date(date);
  const expectedMonth = newDate.getMonth();
  const time = newDate.setFullYear(newDate.getFullYear() + amount);
  return expectedMonth === 1 && newDate.getMonth() === 2 ? newDate.setDate(0) : time;
}

// Calculate the distance bettwen 2 days of the week
function dayDiff(day, from) {
  return (day - from + 7) % 7;
}

// Get the date of the specified day of the week of given base date
function dayOfTheWeekOf(baseDate, dayOfWeek, weekStart = 0) {
  const baseDay = new Date(baseDate).getDay();
  return addDays(baseDate, dayDiff(dayOfWeek, weekStart) - dayDiff(baseDay, weekStart));
}

// Get the ISO week of a date
function getWeek(date) {
  // start of ISO week is Monday
  const thuOfTheWeek = dayOfTheWeekOf(date, 4, 1);
  // 1st week == the week where the 4th of January is in
  const firstThu = dayOfTheWeekOf(new Date(thuOfTheWeek).setMonth(0, 4), 4, 1);
  return Math.round((thuOfTheWeek - firstThu) / 604800000) + 1;
}

// Get the start year of the period of years that includes given date
// years: length of the year period
function startOfYearPeriod(date, years) {
  /* @see https://en.wikipedia.org/wiki/Year_zero#ISO_8601 */
  const year = new Date(date).getFullYear();
  return Math.floor(year / years) * years;
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/lib/dom.js":
/*!*********************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/lib/dom.js ***!
  \*********************************************************/
/*! exports provided: parseHTML, isVisible, hideElement, showElement, emptyChildNodes, replaceChildNodes */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parseHTML", function() { return parseHTML; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isVisible", function() { return isVisible; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hideElement", function() { return hideElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "showElement", function() { return showElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "emptyChildNodes", function() { return emptyChildNodes; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "replaceChildNodes", function() { return replaceChildNodes; });
const range = document.createRange();

function parseHTML(html) {
  return range.createContextualFragment(html);
}

// equivalent to jQuery's :visble
function isVisible(el) {
  return !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);
}

function hideElement(el) {
  if (el.style.display === 'none') {
    return;
  }
  // back up the existing display setting in data-style-display
  if (el.style.display) {
    el.dataset.styleDisplay = el.style.display;
  }
  el.style.display = 'none';
}

function showElement(el) {
  if (el.style.display !== 'none') {
    return;
  }
  if (el.dataset.styleDisplay) {
    // restore backed-up dispay property
    el.style.display = el.dataset.styleDisplay;
    delete el.dataset.styleDisplay;
  } else {
    el.style.display = '';
  }
}

function emptyChildNodes(el) {
  if (el.firstChild) {
    el.removeChild(el.firstChild);
    emptyChildNodes(el);
  }
}

function replaceChildNodes(el, newChildNodes) {
  emptyChildNodes(el);
  if (newChildNodes instanceof DocumentFragment) {
    el.appendChild(newChildNodes);
  } else if (typeof newChildNodes === 'string') {
    el.appendChild(parseHTML(newChildNodes));
  } else if (typeof newChildNodes.forEach === 'function') {
    newChildNodes.forEach((node) => {
      el.appendChild(node);
    });
  }
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/lib/event.js":
/*!***********************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/lib/event.js ***!
  \***********************************************************/
/*! exports provided: registerListeners, unregisterListeners, findElementInEventPath */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "registerListeners", function() { return registerListeners; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "unregisterListeners", function() { return unregisterListeners; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "findElementInEventPath", function() { return findElementInEventPath; });
const listenerRegistry = new WeakMap();
const {addEventListener, removeEventListener} = EventTarget.prototype;

// Register event listeners to a key object
// listeners: array of listener definitions;
//   - each definition must be a flat array of event target and the arguments
//     used to call addEventListener() on the target
function registerListeners(keyObj, listeners) {
  let registered = listenerRegistry.get(keyObj);
  if (!registered) {
    registered = [];
    listenerRegistry.set(keyObj, registered);
  }
  listeners.forEach((listener) => {
    addEventListener.call(...listener);
    registered.push(listener);
  });
}

function unregisterListeners(keyObj) {
  let listeners = listenerRegistry.get(keyObj);
  if (!listeners) {
    return;
  }
  listeners.forEach((listener) => {
    removeEventListener.call(...listener);
  });
  listenerRegistry.delete(keyObj);
}

// Event.composedPath() polyfill for Edge
// based on https://gist.github.com/kleinfreund/e9787d73776c0e3750dcfcdc89f100ec
if (!Event.prototype.composedPath) {
  const getComposedPath = (node, path = []) => {
    path.push(node);

    let parent;
    if (node.parentNode) {
      parent = node.parentNode;
    } else if (node.host) { // ShadowRoot
      parent = node.host;
    } else if (node.defaultView) {  // Document
      parent = node.defaultView;
    }
    return parent ? getComposedPath(parent, path) : path;
  };

  Event.prototype.composedPath = function () {
    return getComposedPath(this.target);
  };
}

function findFromPath(path, criteria, currentTarget, index = 0) {
  const el = path[index];
  if (criteria(el)) {
    return el;
  } else if (el === currentTarget || !el.parentElement) {
    // stop when reaching currentTarget or <html>
    return;
  }
  return findFromPath(path, criteria, currentTarget, index + 1);
}

// Search for the actual target of a delegated event
function findElementInEventPath(ev, selector) {
  const criteria = typeof selector === 'function' ? selector : el => el.matches(selector);
  return findFromPath(ev.composedPath(), criteria, ev.currentTarget);
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/lib/utils.js":
/*!***********************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/lib/utils.js ***!
  \***********************************************************/
/*! exports provided: hasProperty, lastItemOf, pushUnique, stringToArray, isInRange, limitToRange, createTagRepeat, optimizeTemplateHTML */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hasProperty", function() { return hasProperty; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "lastItemOf", function() { return lastItemOf; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "pushUnique", function() { return pushUnique; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "stringToArray", function() { return stringToArray; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isInRange", function() { return isInRange; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "limitToRange", function() { return limitToRange; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createTagRepeat", function() { return createTagRepeat; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "optimizeTemplateHTML", function() { return optimizeTemplateHTML; });
function hasProperty(obj, prop) {
  return Object.prototype.hasOwnProperty.call(obj, prop);
}

function lastItemOf(arr) {
  return arr[arr.length - 1];
}

// push only the items not included in the array
function pushUnique(arr, ...items) {
  items.forEach((item) => {
    if (arr.includes(item)) {
      return;
    }
    arr.push(item);
  });
  return arr;
}

function stringToArray(str, separator) {
  // convert empty string to an empty array
  return str ? str.split(separator) : [];
}

function isInRange(testVal, min, max) {
  const minOK = min === undefined || testVal >= min;
  const maxOK = max === undefined || testVal <= max;
  return minOK && maxOK;
}

function limitToRange(val, min, max) {
  if (val < min) {
    return min;
  }
  if (val > max) {
    return max;
  }
  return val;
}

function createTagRepeat(tagName, repeat, attributes = {}, index = 0, html = '') {
  const openTagSrc = Object.keys(attributes).reduce((src, attr) => {
    let val = attributes[attr];
    if (typeof val === 'function') {
      val = val(index);
    }
    return `${src} ${attr}="${val}"`;
  }, tagName);
  html += `<${openTagSrc}></${tagName}>`;

  const next = index + 1;
  return next < repeat
    ? createTagRepeat(tagName, repeat, attributes, next, html)
    : html;
}

// Remove the spacing surrounding tags for HTML parser not to create text nodes
// before/after elements
function optimizeTemplateHTML(html) {
  return html.replace(/>\s+/g, '>').replace(/\s+</, '<');
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/main.js":
/*!******************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/main.js ***!
  \******************************************************/
/*! exports provided: Datepicker, DateRangePicker */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Datepicker_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Datepicker.js */ "./node_modules/vanillajs-datepicker/js/Datepicker.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "Datepicker", function() { return _Datepicker_js__WEBPACK_IMPORTED_MODULE_0__["default"]; });

/* harmony import */ var _DateRangePicker_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DateRangePicker.js */ "./node_modules/vanillajs-datepicker/js/DateRangePicker.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "DateRangePicker", function() { return _DateRangePicker_js__WEBPACK_IMPORTED_MODULE_1__["default"]; });







/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/options/defaultOptions.js":
/*!************************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/options/defaultOptions.js ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// config options updatable by setOptions() and their default values
const defaultOptions = {
  autohide: false,
  beforeShowDay: null,
  beforeShowDecade: null,
  beforeShowMonth: null,
  beforeShowYear: null,
  calendarWeeks: false,
  clearBtn: false,
  dateDelimiter: ',',
  datesDisabled: [],
  daysOfWeekDisabled: [],
  daysOfWeekHighlighted: [],
  defaultViewDate: undefined, // placeholder, defaults to today() by the program
  disableTouchKeyboard: false,
  format: 'mm/dd/yyyy',
  language: 'en',
  maxDate: null,
  maxNumberOfDates: 1,
  maxView: 3,
  minDate: null,
  nextArrow: '»',
  orientation: 'auto',
  prevArrow: '«',
  showDaysOfWeek: true,
  showOnFocus: true,
  startView: 0,
  title: '',
  todayBtn: false,
  todayBtnMode: 0,
  todayHighlight: false,
  weekStart: 0,
};

/* harmony default export */ __webpack_exports__["default"] = (defaultOptions);


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/options/processOptions.js":
/*!************************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/options/processOptions.js ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return processOptions; });
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");
/* harmony import */ var _lib_date_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../lib/date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");
/* harmony import */ var _lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../lib/date-format.js */ "./node_modules/vanillajs-datepicker/js/lib/date-format.js");
/* harmony import */ var _lib_dom_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../lib/dom.js */ "./node_modules/vanillajs-datepicker/js/lib/dom.js");
/* harmony import */ var _defaultOptions_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./defaultOptions.js */ "./node_modules/vanillajs-datepicker/js/options/defaultOptions.js");






const {
  language: defaultLang,
  format: defaultFormat,
  weekStart: defaultWeekStart,
} = _defaultOptions_js__WEBPACK_IMPORTED_MODULE_4__["default"];

// Reducer function to filter out invalid day-of-week from the input
function sanitizeDOW(dow, day) {
  return dow.length < 6 && day >= 0 && day < 7
    ? Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["pushUnique"])(dow, day)
    : dow;
}

function calcEndOfWeek(startOfWeek) {
  return (startOfWeek + 6) % 7;
}

// validate input date. if invalid, fallback to the original value
function validateDate(value, format, locale, origValue) {
  const date = Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["parseDate"])(value, format, locale);
  return date !== undefined ? date : origValue;
}

// Validate viewId. if invalid, fallback to the original value
function validateViewId(value, origValue) {
  const viewId = parseInt(value, 10);
  return viewId >= 0 && viewId < 4 ? viewId : origValue;
}

// Create Datepicker configuration to set
function processOptions(options, datepicker) {
  const inOpts = Object.assign({}, options);
  const config = {};
  const locales = datepicker.constructor.locales;
  let {
    format,
    language,
    locale,
    maxDate,
    maxView,
    minDate,
    startView,
    weekStart,
  } = datepicker.config || {};

  if (inOpts.language) {
    let lang;
    if (inOpts.language !== language) {
      if (locales[inOpts.language]) {
        lang = inOpts.language;
      } else {
        // Check if langauge + region tag can fallback to the one without
        // region (e.g. fr-CA → fr)
        lang = inOpts.language.split('-')[0];
        if (locales[lang] === undefined) {
          lang = false;
        }
      }
    }
    delete inOpts.language;
    if (lang) {
      language = config.language = lang;

      // update locale as well when updating language
      const origLocale = locale || locales[defaultLang];
      // use default language's properties for the fallback
      locale = Object.assign({
        format: defaultFormat,
        weekStart: defaultWeekStart
      }, locales[defaultLang]);
      if (language !== defaultLang) {
        Object.assign(locale, locales[language]);
      }
      config.locale = locale;
      // if format and/or weekStart are the same as old locale's defaults,
      // update them to new locale's defaults
      if (format === origLocale.format) {
        format = config.format = locale.format;
      }
      if (weekStart === origLocale.weekStart) {
        weekStart = config.weekStart = locale.weekStart;
        config.weekEnd = calcEndOfWeek(locale.weekStart);
      }
    }
  }

  if (inOpts.format) {
    const hasToDisplay = typeof inOpts.format.toDisplay === 'function';
    const hasToValue = typeof inOpts.format.toValue === 'function';
    const validFormatString = _lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["reFormatTokens"].test(inOpts.format);
    if ((hasToDisplay && hasToValue) || validFormatString) {
      format = config.format = inOpts.format;
    }
    delete inOpts.format;
  }

  //*** dates ***//
  // while min and maxDate for "no limit" in the options are better to be null
  // (especially when updating), the ones in the config have to be undefined
  // because null is treated as 0 (= unix epoch) when comparing with time value
  let minDt = minDate;
  let maxDt = maxDate;
  if (inOpts.minDate !== undefined) {
    minDt = inOpts.minDate === null
      ? Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dateValue"])(0, 0, 1)  // set 0000-01-01 to prevent negative values for year
      : validateDate(inOpts.minDate, format, locale, minDt);
    delete inOpts.minDate;
  }
  if (inOpts.maxDate !== undefined) {
    maxDt = inOpts.maxDate === null
      ? undefined
      : validateDate(inOpts.maxDate, format, locale, maxDt);
    delete inOpts.maxDate;
  }
  if (maxDt < minDt) {
    minDate = config.minDate = maxDt;
    maxDate = config.maxDate = minDt;
  } else {
    if (minDate !== minDt) {
      minDate = config.minDate = minDt;
    }
    if (maxDate !== maxDt) {
      maxDate = config.maxDate = maxDt;
    }
  }

  if (inOpts.datesDisabled) {
    config.datesDisabled = inOpts.datesDisabled.reduce((dates, dt) => {
      const date = Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["parseDate"])(dt, format, locale);
      return date !== undefined ? Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["pushUnique"])(dates, date) : dates;
    }, []);
    delete inOpts.datesDisabled;
  }
  if (inOpts.defaultViewDate !== undefined) {
    const viewDate = Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["parseDate"])(inOpts.defaultViewDate, format, locale);
    if (viewDate !== undefined) {
      config.defaultViewDate = viewDate;
    }
    delete inOpts.defaultViewDate;
  }

  //*** days of week ***//
  if (inOpts.weekStart !== undefined) {
    const wkStart = Number(inOpts.weekStart) % 7;
    if (!isNaN(wkStart)) {
      weekStart = config.weekStart = wkStart;
      config.weekEnd = calcEndOfWeek(wkStart);
    }
    delete inOpts.weekStart;
  }
  if (inOpts.daysOfWeekDisabled) {
    config.daysOfWeekDisabled = inOpts.daysOfWeekDisabled.reduce(sanitizeDOW, []);
    delete inOpts.daysOfWeekDisabled;
  }
  if (inOpts.daysOfWeekHighlighted) {
    config.daysOfWeekHighlighted = inOpts.daysOfWeekHighlighted.reduce(sanitizeDOW, []);
    delete inOpts.daysOfWeekHighlighted;
  }

  //*** multi date ***//
  if (inOpts.maxNumberOfDates !== undefined) {
    const maxNumberOfDates = parseInt(inOpts.maxNumberOfDates, 10);
    if (maxNumberOfDates >= 0) {
      config.maxNumberOfDates = maxNumberOfDates;
      config.multidate = maxNumberOfDates !== 1;
    }
    delete inOpts.maxNumberOfDates;
  }
  if (inOpts.dateDelimiter) {
    config.dateDelimiter = String(inOpts.dateDelimiter);
    delete inOpts.dateDelimiter;
  }

  //*** view mode ***//
  let newMaxView = maxView;
  if (inOpts.maxView !== undefined) {
    newMaxView = validateViewId(inOpts.maxView, maxView);
    delete inOpts.maxView;
  }
  if (newMaxView !== maxView) {
    maxView = config.maxView = newMaxView;
  }

  let newStartView = startView;
  if (inOpts.startView !== undefined) {
    newStartView = validateViewId(inOpts.startView, newStartView);
    delete inOpts.startView;
  }
  // ensure start view < max
  newStartView = maxView < newStartView ? maxView : newStartView;
  if (newStartView !== startView) {
    config.startView = newStartView;
  }

  //*** template ***//
  if (inOpts.prevArrow) {
    const prevArrow = Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_3__["parseHTML"])(inOpts.prevArrow);
    if (prevArrow.childNodes.length > 0) {
      config.prevArrow = prevArrow.childNodes;
    }
    delete inOpts.prevArrow;
  }
  if (inOpts.nextArrow) {
    const nextArrow = Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_3__["parseHTML"])(inOpts.nextArrow);
    if (nextArrow.childNodes.length > 0) {
      config.nextArrow = nextArrow.childNodes;
    }
    delete inOpts.nextArrow;
  }

  //*** misc ***//
  if (inOpts.disableTouchKeyboard !== undefined) {
    config.disableTouchKeyboard = 'ontouchstart' in document && !!inOpts.disableTouchKeyboard;
    delete inOpts.disableTouchKeyboard;
  }
  if (inOpts.orientation) {
    const orientation = inOpts.orientation.toLowerCase().split(/\s+/g);
    config.orientation = {
      x: orientation.find(x => (x === 'left' || x === 'right')) || 'auto',
      y: orientation.find(y => (y === 'top' || y === 'bottom')) || 'auto',
    };
    delete inOpts.orientation;
  }
  if (inOpts.todayBtnMode !== undefined) {
    switch(inOpts.todayBtnMode) {
      case 0:
      case 1:
        config.todayBtnMode = inOpts.todayBtnMode;
    }
    delete inOpts.todayBtnMode;
  }

  //*** copy the rest ***//
  Object.keys(inOpts).forEach((key) => {
    if (inOpts[key] !== undefined && Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["hasProperty"])(_defaultOptions_js__WEBPACK_IMPORTED_MODULE_4__["default"], key)) {
      config[key] = inOpts[key];
    }
  });

  return config;
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/picker/Picker.js":
/*!***************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/picker/Picker.js ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Picker; });
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");
/* harmony import */ var _lib_date_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../lib/date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");
/* harmony import */ var _lib_dom_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../lib/dom.js */ "./node_modules/vanillajs-datepicker/js/lib/dom.js");
/* harmony import */ var _lib_event_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../lib/event.js */ "./node_modules/vanillajs-datepicker/js/lib/event.js");
/* harmony import */ var _templates_pickerTemplate_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./templates/pickerTemplate.js */ "./node_modules/vanillajs-datepicker/js/picker/templates/pickerTemplate.js");
/* harmony import */ var _views_DaysView_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./views/DaysView.js */ "./node_modules/vanillajs-datepicker/js/picker/views/DaysView.js");
/* harmony import */ var _views_MonthsView_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./views/MonthsView.js */ "./node_modules/vanillajs-datepicker/js/picker/views/MonthsView.js");
/* harmony import */ var _views_YearsView_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./views/YearsView.js */ "./node_modules/vanillajs-datepicker/js/picker/views/YearsView.js");
/* harmony import */ var _events_functions_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../events/functions.js */ "./node_modules/vanillajs-datepicker/js/events/functions.js");
/* harmony import */ var _events_pickerListeners_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../events/pickerListeners.js */ "./node_modules/vanillajs-datepicker/js/events/pickerListeners.js");











function processPickerOptions(picker, options) {
  if (options.title !== undefined) {
    if (options.title) {
      picker.controls.title.textContent = options.title;
      Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["showElement"])(picker.controls.title);
    } else {
      picker.controls.title.textContent = '';
      Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["hideElement"])(picker.controls.title);
    }
  }
  if (options.prevArrow) {
    const prevBtn = picker.controls.prevBtn;
    Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["emptyChildNodes"])(prevBtn);
    options.prevArrow.forEach((node) => {
      prevBtn.appendChild(node.cloneNode(true));
    });
  }
  if (options.nextArrow) {
    const nextBtn = picker.controls.nextBtn;
    Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["emptyChildNodes"])(nextBtn);
    options.nextArrow.forEach((node) => {
      nextBtn.appendChild(node.cloneNode(true));
    });
  }
  if (options.locale) {
    picker.controls.todayBtn.textContent = options.locale.today;
    picker.controls.clearBtn.textContent = options.locale.clear;
  }
  if (options.todayBtn !== undefined) {
    if (options.todayBtn) {
      Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["showElement"])(picker.controls.todayBtn);
    } else {
      Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["hideElement"])(picker.controls.todayBtn);
    }
  }
  if (Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["hasProperty"])(options, 'minDate') || Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["hasProperty"])(options, 'maxDate')) {
    const {minDate, maxDate} = picker.datepicker.config;
    picker.controls.todayBtn.disabled = !Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["isInRange"])(Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["today"])(), minDate, maxDate);
  }
  if (options.clearBtn !== undefined) {
    if (options.clearBtn) {
      Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["showElement"])(picker.controls.clearBtn);
    } else {
      Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["hideElement"])(picker.controls.clearBtn);
    }
  }
}

// Compute view date to reset, which will be...
// - the last item of the selected dates or defaultViewDate if no selection
// - limitted to minDate or maxDate if it exceeds the range
function computeResetViewDate(datepicker) {
  const {dates, config} = datepicker;
  const viewDate = dates.length > 0 ? Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["lastItemOf"])(dates) : config.defaultViewDate;
  return Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["limitToRange"])(viewDate, config.minDate, config.maxDate);
}

// Change current view's view date
function setViewDate(picker, newDate) {
  const oldViewDate = new Date(picker.viewDate);
  const newViewDate = new Date(newDate);
  const {id, year, first, last} = picker.currentView;
  const viewYear = newViewDate.getFullYear();

  picker.viewDate = newDate;
  if (viewYear !== oldViewDate.getFullYear()) {
    Object(_events_functions_js__WEBPACK_IMPORTED_MODULE_8__["triggerDatepickerEvent"])(picker.datepicker, 'changeYear');
  }
  if (newViewDate.getMonth() !== oldViewDate.getMonth()) {
    Object(_events_functions_js__WEBPACK_IMPORTED_MODULE_8__["triggerDatepickerEvent"])(picker.datepicker, 'changeMonth');
  }

  // return whether the new date is in different period on time from the one
  // displayed in the current view
  // when true, the view needs to be re-rendered on the next UI refresh.
  switch (id) {
    case 0:
      return newDate < first || newDate > last;
    case 1:
      return viewYear !== year;
    default:
      return viewYear < first || viewYear > last;
  }
}

function getTextDirection(el) {
  return window.getComputedStyle(el).direction;
}

// Class representing the picker UI
class Picker {
  constructor(datepicker) {
    this.datepicker = datepicker;

    const template = _templates_pickerTemplate_js__WEBPACK_IMPORTED_MODULE_4__["default"].replace(/%buttonClass%/g, datepicker.config.buttonClass);
    const element = this.element = Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["parseHTML"])(template).firstChild;
    const [header, main, footer] = element.firstChild.children;
    const title = header.firstElementChild;
    const [prevBtn, viewSwitch, nextBtn] = header.lastElementChild.children;
    const [todayBtn, clearBtn] = footer.firstChild.children;
    const controls = {
      title,
      prevBtn,
      viewSwitch,
      nextBtn,
      todayBtn,
      clearBtn,
    };
    this.main = main;
    this.controls = controls;

    const elementClass = datepicker.inline ? 'inline' : 'dropdown';
    element.classList.add(`datepicker-${elementClass}`);

    processPickerOptions(this, datepicker.config);
    this.viewDate = computeResetViewDate(datepicker);

    // set up event listeners
    Object(_lib_event_js__WEBPACK_IMPORTED_MODULE_3__["registerListeners"])(datepicker, [
      [element, 'click', _events_pickerListeners_js__WEBPACK_IMPORTED_MODULE_9__["onClickPicker"].bind(null, datepicker)],
      [main, 'click', _events_pickerListeners_js__WEBPACK_IMPORTED_MODULE_9__["onClickView"].bind(null, datepicker)],
      [controls.viewSwitch, 'click', _events_pickerListeners_js__WEBPACK_IMPORTED_MODULE_9__["onClickViewSwitch"].bind(null, datepicker)],
      [controls.prevBtn, 'click', _events_pickerListeners_js__WEBPACK_IMPORTED_MODULE_9__["onClickPrevBtn"].bind(null, datepicker)],
      [controls.nextBtn, 'click', _events_pickerListeners_js__WEBPACK_IMPORTED_MODULE_9__["onClickNextBtn"].bind(null, datepicker)],
      [controls.todayBtn, 'click', _events_pickerListeners_js__WEBPACK_IMPORTED_MODULE_9__["onClickTodayBtn"].bind(null, datepicker)],
      [controls.clearBtn, 'click', _events_pickerListeners_js__WEBPACK_IMPORTED_MODULE_9__["onClickClearBtn"].bind(null, datepicker)],
    ]);

    // set up views
    this.views = [
      new _views_DaysView_js__WEBPACK_IMPORTED_MODULE_5__["default"](this),
      new _views_MonthsView_js__WEBPACK_IMPORTED_MODULE_6__["default"](this),
      new _views_YearsView_js__WEBPACK_IMPORTED_MODULE_7__["default"](this, {id: 2, name: 'years', cellClass: 'year', step: 1}),
      new _views_YearsView_js__WEBPACK_IMPORTED_MODULE_7__["default"](this, {id: 3, name: 'decades', cellClass: 'decade', step: 10}),
    ];
    this.currentView = this.views[datepicker.config.startView];

    this.currentView.render();
    this.main.appendChild(this.currentView.element);
    datepicker.config.container.appendChild(this.element);
  }

  setOptions(options) {
    processPickerOptions(this, options);
    this.views.forEach((view) => {
      view.init(options, false);
    });
    this.currentView.render();
  }

  detach(){
    this.datepicker.config.container.removeChild(this.element);
  }

  show() {
    if (this.active) {
      return;
    }
    this.element.classList.add('active');
    this.active = true;

    const datepicker = this.datepicker;
    if (!datepicker.inline) {
      // ensure picker's direction matches input's
      const inputDirection = getTextDirection(datepicker.inputField);
      if (inputDirection !== getTextDirection(datepicker.config.container)) {
        this.element.dir = inputDirection;
      } else if (this.element.dir) {
        this.element.removeAttribute('dir');
      }

      this.place();
      if (datepicker.config.disableTouchKeyboard) {
        datepicker.inputField.blur();
      }
    }
    Object(_events_functions_js__WEBPACK_IMPORTED_MODULE_8__["triggerDatepickerEvent"])(datepicker, 'show');
  }

  hide() {
    if (!this.active) {
      return;
    }
    this.datepicker.exitEditMode();
    this.element.classList.remove('active');
    this.active = false;
    Object(_events_functions_js__WEBPACK_IMPORTED_MODULE_8__["triggerDatepickerEvent"])(this.datepicker, 'hide');
  }

  place() {
    const {classList, style} = this.element;
    const {config, inputField} = this.datepicker;
    const container = config.container;
    const {
      width: calendarWidth,
      height: calendarHeight,
    } = this.element.getBoundingClientRect();
    const {
      left: containerLeft,
      top: containerTop,
      width: containerWidth,
    } = container.getBoundingClientRect();
    const {
      left: inputLeft,
      top: inputTop,
      width: inputWidth,
      height: inputHeight
    } = inputField.getBoundingClientRect();
    let {x: orientX, y: orientY} = config.orientation;
    let scrollTop;
    let left;
    let top;

    if (container === document.body) {
      scrollTop = window.scrollY;
      left = inputLeft + window.scrollX;
      top = inputTop + scrollTop;
    } else {
      scrollTop = container.scrollTop;
      left = inputLeft - containerLeft;
      top = inputTop - containerTop + scrollTop;
    }

    if (orientX === 'auto') {
      if (left < 0) {
        // align to the left and move into visible area if input's left edge < window's
        orientX = 'left';
        left = 10;
      } else if (left + calendarWidth > containerWidth) {
        // align to the right if canlendar's right edge > container's
        orientX = 'right';
      } else {
        orientX = getTextDirection(inputField) === 'rtl' ? 'right' : 'left';
      }
    }
    if (orientX === 'right') {
      left -= calendarWidth - inputWidth;
    }

    if (orientY === 'auto') {
      orientY = top - calendarHeight < scrollTop ? 'bottom' : 'top';
    }
    if (orientY === 'top') {
      top -= calendarHeight;
    } else {
      top += inputHeight;
    }

    classList.remove(
      'datepicker-orient-top',
      'datepicker-orient-bottom',
      'datepicker-orient-right',
      'datepicker-orient-left'
    );
    classList.add(`datepicker-orient-${orientY}`, `datepicker-orient-${orientX}`);

    style.top = top ? `${top}px` : top;
    style.left = left ? `${left}px` : left;
  }

  setViewSwitchLabel(labelText) {
    this.controls.viewSwitch.textContent = labelText;
  }

  setPrevBtnDisabled(disabled) {
    this.controls.prevBtn.disabled = disabled;
  }

  setNextBtnDisabled(disabled) {
    this.controls.nextBtn.disabled = disabled;
  }

  changeView(viewId) {
    const oldView = this.currentView;
    const newView =  this.views[viewId];
    if (newView.id !== oldView.id) {
      this.currentView = newView;
      this._renderMethod = 'render';
      Object(_events_functions_js__WEBPACK_IMPORTED_MODULE_8__["triggerDatepickerEvent"])(this.datepicker, 'changeView');
      this.main.replaceChild(newView.element, oldView.element);
    }
    return this;
  }

  // Change the focused date (view date)
  changeFocus(newViewDate) {
    this._renderMethod = setViewDate(this, newViewDate) ? 'render' : 'refreshFocus';
    this.views.forEach((view) => {
      view.updateFocus();
    });
    return this;
  }

  // Apply the change of the selected dates
  update() {
    const newViewDate = computeResetViewDate(this.datepicker);
    this._renderMethod = setViewDate(this, newViewDate) ? 'render' : 'refresh';
    this.views.forEach((view) => {
      view.updateFocus();
      view.updateSelection();
    });
    return this;
  }

  // Refresh the picker UI
  render() {
    const renderMethod = this._renderMethod || 'render';
    delete this._renderMethod;

    this.currentView[renderMethod]();
  }
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/picker/templates/calendarWeeksTemplate.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/picker/templates/calendarWeeksTemplate.js ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");


const calendarWeeksTemplate = Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["optimizeTemplateHTML"])(`<div class="calendar-weeks">
  <div class="days-of-week"><span class="dow"></span></div>
  <div class="weeks">${Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["createTagRepeat"])('span', 6, {class: 'week'})}</div>
</div>`);

/* harmony default export */ __webpack_exports__["default"] = (calendarWeeksTemplate);


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/picker/templates/daysTemplate.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/picker/templates/daysTemplate.js ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");


const daysTemplate = Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["optimizeTemplateHTML"])(`<div class="days">
  <div class="days-of-week">${Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["createTagRepeat"])('span', 7, {class: 'dow'})}</div>
  <div class="datepicker-grid">${Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["createTagRepeat"])('span', 42)}</div>
</div>`);

/* harmony default export */ __webpack_exports__["default"] = (daysTemplate);


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/picker/templates/pickerTemplate.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/picker/templates/pickerTemplate.js ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");


const pickerTemplate = Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["optimizeTemplateHTML"])(`<div class="datepicker">
  <div class="datepicker-picker">
    <div class="datepicker-header">
      <div class="datepicker-title"></div>
      <div class="datepicker-controls">
        <button class="%buttonClass% prev-btn"></button>
        <button class="%buttonClass% view-switch"></button>
        <button class="%buttonClass% next-btn"></button>
      </div>
    </div>
    <div class="datepicker-main"></div>
    <div class="datepicker-footer">
      <div class="datepicker-controls">
        <button class="%buttonClass% today-btn"></button>
        <button class="%buttonClass% clear-btn"></button>
      </div>
    </div>
  </div>
</div>`);

/* harmony default export */ __webpack_exports__["default"] = (pickerTemplate);


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/picker/views/DaysView.js":
/*!***********************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/picker/views/DaysView.js ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return DaysView; });
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");
/* harmony import */ var _lib_date_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../lib/date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");
/* harmony import */ var _lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../lib/date-format.js */ "./node_modules/vanillajs-datepicker/js/lib/date-format.js");
/* harmony import */ var _lib_dom_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../lib/dom.js */ "./node_modules/vanillajs-datepicker/js/lib/dom.js");
/* harmony import */ var _templates_daysTemplate_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../templates/daysTemplate.js */ "./node_modules/vanillajs-datepicker/js/picker/templates/daysTemplate.js");
/* harmony import */ var _templates_calendarWeeksTemplate_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../templates/calendarWeeksTemplate.js */ "./node_modules/vanillajs-datepicker/js/picker/templates/calendarWeeksTemplate.js");
/* harmony import */ var _View_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./View.js */ "./node_modules/vanillajs-datepicker/js/picker/views/View.js");








class DaysView extends _View_js__WEBPACK_IMPORTED_MODULE_6__["default"] {
  constructor(picker) {
    super(picker, {
      id: 0,
      name: 'days',
      cellClass: 'day',
    });
  }

  init(options, onConstruction = true) {
    if (onConstruction) {
      const inner = Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_3__["parseHTML"])(_templates_daysTemplate_js__WEBPACK_IMPORTED_MODULE_4__["default"]).firstChild;
      this.dow = inner.firstChild;
      this.grid = inner.lastChild;
      this.element.appendChild(inner);
    }
    super.init(options);
  }

  setOptions(options) {
    let updateDOW;

    if (Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["hasProperty"])(options, 'minDate')) {
      this.minDate = options.minDate;
    }
    if (Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["hasProperty"])(options, 'maxDate')) {
      this.maxDate = options.maxDate;
    }
    if (options.datesDisabled) {
      this.datesDisabled = options.datesDisabled;
    }
    if (options.daysOfWeekDisabled) {
      this.daysOfWeekDisabled = options.daysOfWeekDisabled;
      updateDOW = true;
    }
    if (options.daysOfWeekHighlighted) {
      this.daysOfWeekHighlighted = options.daysOfWeekHighlighted;
    }
    if (options.todayHighlight !== undefined) {
      this.todayHighlight = options.todayHighlight;
    }
    if (options.weekStart !== undefined) {
      this.weekStart = options.weekStart;
      this.weekEnd = options.weekEnd;
      updateDOW = true;
    }
    if (options.locale) {
      const locale = this.locale = options.locale;
      this.dayNames = locale.daysMin;
      this.switchLabelFormat = locale.titleFormat;
      this.switchLabel = Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["formatDate"])(this.picker.viewDate, locale.titleFormat, locale);
      updateDOW = true;
    }
    if (options.beforeShowDay !== undefined) {
      this.beforeShow = typeof options.beforeShowDay === 'function'
        ? options.beforeShowDay
        : undefined;
    }

    if (options.calendarWeeks !== undefined) {
      if (options.calendarWeeks && !this.calendarWeeks) {
        const weeksElem = Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_3__["parseHTML"])(_templates_calendarWeeksTemplate_js__WEBPACK_IMPORTED_MODULE_5__["default"]).firstChild;
        this.calendarWeeks = {
          element: weeksElem,
          dow: weeksElem.firstChild,
          weeks: weeksElem.lastChild,
        };
        this.element.insertBefore(weeksElem, this.element.firstChild);
      } else if (this.calendarWeeks && !options.calendarWeeks) {
        this.element.removeChild(this.calendarWeeks.element);
        this.calendarWeeks = null;
      }
    }
    if (options.showDaysOfWeek !== undefined) {
      if (options.showDaysOfWeek) {
        Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_3__["showElement"])(this.dow);
        if (this.calendarWeeks) {
          Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_3__["showElement"])(this.calendarWeeks.dow);
        }
      } else {
        Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_3__["hideElement"])(this.dow);
        if (this.calendarWeeks) {
          Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_3__["hideElement"])(this.calendarWeeks.dow);
        }
      }
    }

    // update days-of-week when locale, daysOfweekDisabled or weekStart is changed
    if (updateDOW) {
      Array.from(this.dow.children).forEach((el, index) => {
        const dow = (this.weekStart + index) % 7;
        el.textContent = this.dayNames[dow];
        el.className = this.daysOfWeekDisabled.includes(dow) ? 'dow disabled' : 'dow';
      });
    }
  }

  // Apply update on the focused date to view's settings
  updateFocus() {
    const viewDate = new Date(this.picker.viewDate);
    const viewYear = viewDate.getFullYear();
    const viewMonth = viewDate.getMonth();
    const firstOfMonth = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dateValue"])(viewYear, viewMonth, 1);
    const start = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dayOfTheWeekOf"])(firstOfMonth, this.weekStart, this.weekStart);

    this.first = firstOfMonth;
    this.last = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dateValue"])(viewYear, viewMonth + 1, 0);
    this.start = start;

    this.switchLabel = Object(_lib_date_format_js__WEBPACK_IMPORTED_MODULE_2__["formatDate"])(viewDate, this.switchLabelFormat, this.locale);
    this.focused = this.picker.viewDate;
  }

  // Apply update on the selected dates to view's settings
  updateSelection() {
    const {dates, range} = this.picker.datepicker;
    this.selected = dates;
    this.range = range;
  }

   // Update the entire view UI
  render() {
    // update today marker on ever render
    this.today = this.todayHighlight ? Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["today"])() : undefined;
    // refresh disabled dates on every render in order to clear the ones added
    // by beforeShow hook at previous render
    this.disabled = [...this.datesDisabled];

    this.picker.setViewSwitchLabel(this.switchLabel);
    this.picker.setPrevBtnDisabled(this.first <= this.minDate);
    this.picker.setNextBtnDisabled(this.last >= this.maxDate);

    if (this.calendarWeeks) {
      // start of the UTC week (Monday) of the 1st of the month
      const startOfWeek = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dayOfTheWeekOf"])(this.first, 1, 1);
      Array.from(this.calendarWeeks.weeks.children).forEach((el, index) => {
        el.textContent = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["getWeek"])(Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addWeeks"])(startOfWeek, index));
      });
    }
    Array.from(this.grid.children).forEach((el, index) => {
      const classList = el.classList;
      const current = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["addDays"])(this.start, index);
      const date = new Date(current);
      const day = date.getDay();

      el.className = `datepicker-cell ${this.cellClass}`;
      el.dataset.date = current;
      el.textContent = date.getDate();

      if (current < this.first) {
        classList.add('prev');
      } else if (current > this.last) {
        classList.add('next');
      }
      if (this.today === current) {
        classList.add('today');
      }
      if (current < this.minDate || current > this.maxDate || this.disabled.includes(current)) {
        classList.add('disabled');
      }
      if (this.daysOfWeekDisabled.includes(day)) {
        classList.add('disabled');
        Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["pushUnique"])(this.disabled, current);
      }
      if (this.daysOfWeekHighlighted.includes(day)) {
        classList.add('highlighted');
      }
      if (this.range){
        const [rangeStart, rangeEnd] = this.range;
        if (current > rangeStart && current < rangeEnd) {
          classList.add('range');
        }
        if (current === rangeStart) {
          classList.add('range-start');
        }
        if (current === rangeEnd) {
          classList.add('range-end');
        }
      }
      if (this.selected.includes(current)) {
        classList.add('selected');
      }
      if (current === this.focused) {
        classList.add('focused');
      }

      if (this.beforeShow) {
        this.performBeforeHook(el, current, current);
      }
    });
  }

  // Update the view UI by applying the changes of selected and focused items
  refresh() {
    const [rangeStart, rangeEnd] = this.range || [];
    this.grid
      .querySelectorAll('.range, .range-start, .range-end, .selected, .focused')
      .forEach((el) => {
        el.classList.remove('range', 'range-start', 'range-end', 'selected', 'focused');
      });
    Array.from(this.grid.children).forEach((el) => {
      const current = Number(el.dataset.date);
      const classList = el.classList;
      if (current > rangeStart && current < rangeEnd) {
        classList.add('range');
      }
      if (current === rangeStart) {
        classList.add('range-start');
      }
      if (current === rangeEnd) {
        classList.add('range-end');
      }
      if (this.selected.includes(current)) {
        classList.add('selected');
      }
      if (current === this.focused) {
        classList.add('focused');
      }
    });
  }

  // Update the view UI by applying the change of focused item
  refreshFocus() {
    const index = Math.round((this.focused - this.start) / 86400000);
    this.grid.querySelectorAll('.focused').forEach((el) => {
      el.classList.remove('focused');
    });
    this.grid.children[index].classList.add('focused');
  }
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/picker/views/MonthsView.js":
/*!*************************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/picker/views/MonthsView.js ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return MonthsView; });
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");
/* harmony import */ var _lib_date_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../lib/date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");
/* harmony import */ var _lib_dom_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../lib/dom.js */ "./node_modules/vanillajs-datepicker/js/lib/dom.js");
/* harmony import */ var _View_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./View.js */ "./node_modules/vanillajs-datepicker/js/picker/views/View.js");





class MonthsView extends _View_js__WEBPACK_IMPORTED_MODULE_3__["default"] {
  constructor(picker) {
    super(picker, {
      id: 1,
      name: 'months',
      cellClass: 'month',
    });
  }

  init(options, onConstruction = true) {
    if (onConstruction) {
      this.grid = this.element;
      this.element.classList.add('months', 'datepicker-grid');
      this.grid.appendChild(Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["parseHTML"])(Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["createTagRepeat"])('span', 12, {'data-month': ix => ix})));
    }
    super.init(options);
  }

  setOptions(options) {
    if (options.locale) {
      this.monthNames = options.locale.monthsShort;
    }
    if (Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["hasProperty"])(options, 'minDate')) {
      if (options.minDate === undefined) {
        this.minYear = this.minMonth = this.minDate = undefined;
      } else {
        const minDateObj = new Date(options.minDate);
        this.minYear = minDateObj.getFullYear();
        this.minMonth = minDateObj.getMonth();
        this.minDate = minDateObj.setDate(1);
      }
    }
    if (Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["hasProperty"])(options, 'maxDate')) {
      if (options.maxDate === undefined) {
        this.maxYear = this.maxMonth = this.maxDate = undefined;
      } else {
        const maxDateObj = new Date(options.maxDate);
        this.maxYear = maxDateObj.getFullYear();
        this.maxMonth = maxDateObj.getMonth();
        this.maxDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dateValue"])(this.maxYear, this.maxMonth + 1, 0);
      }
    }
    if (options.beforeShowMonth !== undefined) {
      this.beforeShow = typeof options.beforeShowMonth === 'function'
        ? options.beforeShowMonth
        : undefined;
    }
  }

  // Update view's settings to reflect the viewDate set on the picker
  updateFocus() {
    const viewDate = new Date(this.picker.viewDate);
    this.year = viewDate.getFullYear();
    this.switchLabel = this.year;
    this.focused = viewDate.getMonth();
  }

  // Update view's settings to reflect the selected dates
  updateSelection() {
    this.selected = this.picker.datepicker.dates.reduce((selected, timeValue) => {
      const date = new Date(timeValue);
      const year = date.getFullYear();
      const month = date.getMonth();
      if (selected[year] === undefined) {
        selected[year] = [month];
      } else {
        Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["pushUnique"])(selected[year], month);
      }
      return selected;
    }, {});
  }

  // Update the entire view UI
  render() {
    // refresh disabled months on every render in order to clear the ones added
    // by beforeShow hook at previous render
    this.disabled = [];

    this.picker.setViewSwitchLabel(this.switchLabel);
    this.picker.setPrevBtnDisabled(this.year <= this.minYear);
    this.picker.setNextBtnDisabled(this.year >= this.maxYear);

    const selected = this.selected[this.year] || [];
    const yrOutOfRange = this.year < this.minYear || this.year > this.maxYear;
    const isMinYear = this.year === this.minYear;
    const isMaxYear = this.year === this.maxYear;
    Array.from(this.grid.children).forEach((el, index) => {
      const classList = el.classList;

      el.className = `datepicker-cell ${this.cellClass}`;
      // reset text on every render to clear the custom content set
      // by beforeShow hook at previous render
      el.textContent = this.monthNames[index];

      if (
        yrOutOfRange
        || isMinYear && index < this.minMonth
        || isMaxYear && index > this.maxMonth
      ) {
        classList.add('disabled');
      }
      if (selected.includes(index)) {
        classList.add('selected');
      }
      if (index === this.focused) {
        classList.add('focused');
      }

      if (this.beforeShow) {
        this.performBeforeHook(el, index, Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dateValue"])(this.year, index, 1));
      }
    });
  }

  // Update the view UI by applying the changes of selected and focused items
  refresh() {
    const selected = this.selected[this.year] || [];
    this.grid.querySelectorAll('.selected, .focused').forEach((el) => {
      el.classList.remove('selected', 'focused');
    });
    Array.from(this.grid.children).forEach((el, index) => {
      const classList = el.classList;
      if (selected.includes(index)) {
        classList.add('selected');
      }
      if (index === this.focused) {
        classList.add('focused');
      }
    });
  }

  // Update the view UI by applying the change of focused item
  refreshFocus() {
    this.grid.querySelectorAll('.focused').forEach((el) => {
      el.classList.remove('focused');
    });
    this.grid.children[this.focused].classList.add('focused');
  }
}

/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/picker/views/View.js":
/*!*******************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/picker/views/View.js ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return View; });
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");
/* harmony import */ var _lib_dom_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../lib/dom.js */ "./node_modules/vanillajs-datepicker/js/lib/dom.js");



// Base class of the view classes
class View {
  constructor(picker, config) {
    Object.assign(this, config, {
      picker,
      element: Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_1__["parseHTML"])(`<div class="datepicker-view"></div>`).firstChild,
      selected: [],
    });
    this.init(this.picker.datepicker.config);
  }

  init(options) {
    this.setOptions(options);
    this.updateFocus();
    this.updateSelection();
  }

  // Execute beforeShow() callback and apply the result to the element
  // args:
  // - current - current value on the iteration on view rendering
  // - timeValue - time value of the date to pass to beforeShow()
  performBeforeHook(el, current, timeValue) {
    let result = this.beforeShow(new Date(timeValue));
    switch (typeof result) {
      case 'boolean':
        result = {enabled: result};
        break;
      case 'string':
        result = {classes: result};
    }

    if (result) {
      if (result.enabled === false) {
        el.classList.add('disabled');
        Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["pushUnique"])(this.disabled, current);
      }
      if (result.classes) {
        const extraClasses = result.classes.split(/\s+/);
        el.classList.add(...extraClasses);
        if (extraClasses.includes('disabled')) {
          Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["pushUnique"])(this.disabled, current);
        }
      }
      if (result.content) {
        Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_1__["replaceChildNodes"])(el, result.content);
      }
    }
  }
}


/***/ }),

/***/ "./node_modules/vanillajs-datepicker/js/picker/views/YearsView.js":
/*!************************************************************************!*\
  !*** ./node_modules/vanillajs-datepicker/js/picker/views/YearsView.js ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return YearsView; });
/* harmony import */ var _lib_utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../lib/utils.js */ "./node_modules/vanillajs-datepicker/js/lib/utils.js");
/* harmony import */ var _lib_date_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../lib/date.js */ "./node_modules/vanillajs-datepicker/js/lib/date.js");
/* harmony import */ var _lib_dom_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../lib/dom.js */ "./node_modules/vanillajs-datepicker/js/lib/dom.js");
/* harmony import */ var _View_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./View.js */ "./node_modules/vanillajs-datepicker/js/picker/views/View.js");





function toTitleCase(word) {
  return [...word].reduce((str, ch, ix) => str += ix ? ch : ch.toUpperCase(), '');
}

// Class representing the years and decades view elements
class YearsView extends _View_js__WEBPACK_IMPORTED_MODULE_3__["default"] {
  constructor(picker, config) {
    super(picker, config);
  }

  init(options, onConstruction = true) {
    if (onConstruction) {
      this.navStep = this.step * 10;
      this.beforeShowOption = `beforeShow${toTitleCase(this.cellClass)}`;
      this.grid = this.element;
      this.element.classList.add(this.name, 'datepicker-grid');
      this.grid.appendChild(Object(_lib_dom_js__WEBPACK_IMPORTED_MODULE_2__["parseHTML"])(Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["createTagRepeat"])('span', 12)));
    }
    super.init(options);
  }

  setOptions(options) {
    if (Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["hasProperty"])(options, 'minDate')) {
      if (options.minDate === undefined) {
        this.minYear = this.minDate = undefined;
      } else {
        this.minYear = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["startOfYearPeriod"])(options.minDate, this.step);
        this.minDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dateValue"])(this.minYear, 0, 1);
      }
    }
    if (Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["hasProperty"])(options, 'maxDate')) {
      if (options.maxDate === undefined) {
        this.maxYear = this.maxDate = undefined;
      } else {
        this.maxYear = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["startOfYearPeriod"])(options.maxDate, this.step);
        this.maxDate = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dateValue"])(this.maxYear, 11, 31);
      }
    }
    if (options[this.beforeShowOption] !== undefined) {
      const beforeShow = options[this.beforeShowOption];
      this.beforeShow = typeof beforeShow === 'function' ? beforeShow : undefined;
    }
  }

  // Update view's settings to reflect the viewDate set on the picker
  updateFocus() {
    const viewDate = new Date(this.picker.viewDate);
    const first = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["startOfYearPeriod"])(viewDate, this.navStep);
    const last = first + 9 * this.step;

    this.first = first;
    this.last = last;
    this.start = first - this.step;
    this.switchLabel = `${first}-${last}`;
    this.focused = Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["startOfYearPeriod"])(viewDate, this.step);
  }

  // Update view's settings to reflect the selected dates
  updateSelection() {
    this.selected = this.picker.datepicker.dates.reduce((years, timeValue) => {
      return Object(_lib_utils_js__WEBPACK_IMPORTED_MODULE_0__["pushUnique"])(years, Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["startOfYearPeriod"])(timeValue, this.step));
    }, []);
  }

  // Update the entire view UI
  render() {
    // refresh disabled years on every render in order to clear the ones added
    // by beforeShow hook at previous render
    this.disabled = [];

    this.picker.setViewSwitchLabel(this.switchLabel);
    this.picker.setPrevBtnDisabled(this.first <= this.minYear);
    this.picker.setNextBtnDisabled(this.last >= this.maxYear);

    Array.from(this.grid.children).forEach((el, index) => {
      const classList = el.classList;
      const current = this.start + (index * this.step);

      el.className = `datepicker-cell ${this.cellClass}`;
      el.textContent = el.dataset.year = current;

      if (index === 0) {
        classList.add('prev');
      } else if (index === 11) {
        classList.add('next');
      }
      if (current < this.minYear || current > this.maxYear) {
        classList.add('disabled');
      }
      if (this.selected.includes(current)) {
        classList.add('selected');
      }
      if (current === this.focused) {
        classList.add('focused');
      }

      if (this.beforeShow) {
        this.performBeforeHook(el, current, Object(_lib_date_js__WEBPACK_IMPORTED_MODULE_1__["dateValue"])(current, 0, 1));
      }
    });
  }

  // Update the view UI by applying the changes of selected and focused items
  refresh() {
    this.grid.querySelectorAll('.selected, .focused').forEach((el) => {
      el.classList.remove('selected', 'focused');
    });
    Array.from(this.grid.children).forEach((el) => {
      const current = Number(el.textContent);
      const classList = el.classList;
      if (this.selected.includes(current)) {
        classList.add('selected');
      }
      if (current === this.focused) {
        classList.add('focused');
      }
    });
  }

  // Update the view UI by applying the change of focused item
  refreshFocus() {
    const index = Math.round((this.focused - this.start) / this.step);
    this.grid.querySelectorAll('.focused').forEach((el) => {
      el.classList.remove('focused');
    });
    this.grid.children[index].classList.add('focused');
  }
}


/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vanillajs_datepicker__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vanillajs-datepicker */ "./node_modules/vanillajs-datepicker/js/main.js");
/* harmony import */ var _node_modules_vanillajs_datepicker_js_i18n_locales_ru_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../node_modules/vanillajs-datepicker/js/i18n/locales/ru.js */ "./node_modules/vanillajs-datepicker/js/i18n/locales/ru.js");
/* harmony import */ var _xmlHttpRequest_xmlHttpRequest__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./xmlHttpRequest/xmlHttpRequest */ "./resources/js/xmlHttpRequest/xmlHttpRequest.js");
/* harmony import */ var _xmlHttpRequest_xmlHttpRequest__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_xmlHttpRequest_xmlHttpRequest__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _components_cart_refreshCart__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/cart/refreshCart */ "./resources/js/components/cart/refreshCart.js");
/* harmony import */ var _components_cart_refreshCart__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_components_cart_refreshCart__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _components_card_functions_getPreload__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/card/functions/getPreload */ "./resources/js/components/card/functions/getPreload.js");
/* harmony import */ var _components_card_functions_getPreload__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_components_card_functions_getPreload__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _components_card_functions_qty__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/card/functions/qty */ "./resources/js/components/card/functions/qty.js");
/* harmony import */ var _components_card_functions_qty__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_components_card_functions_qty__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _components_cart_remove__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/cart/remove */ "./resources/js/components/cart/remove.js");
/* harmony import */ var _components_cart_remove__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_components_cart_remove__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _components_card_btnAdd__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/card/btnAdd */ "./resources/js/components/card/btnAdd.js");
/* harmony import */ var _components_card_btnAdd__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_components_card_btnAdd__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _components_card_btnQty__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./components/card/btnQty */ "./resources/js/components/card/btnQty.js");
/* harmony import */ var _components_card_btnQty__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_components_card_btnQty__WEBPACK_IMPORTED_MODULE_8__);


Object.assign(vanillajs_datepicker__WEBPACK_IMPORTED_MODULE_0__["Datepicker"].locales, _node_modules_vanillajs_datepicker_js_i18n_locales_ru_js__WEBPACK_IMPORTED_MODULE_1__["default"]);
window.Axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");






__webpack_require__(/*! ./components/sticky-header/sticky */ "./resources/js/components/sticky-header/sticky.js");

__webpack_require__(/*! ./components/homepage-slider/slider */ "./resources/js/components/homepage-slider/slider.js");

__webpack_require__(/*! ./components/accordion/accordion */ "./resources/js/components/accordion/accordion.js");

__webpack_require__(/*! ./components/tabs/tabs */ "./resources/js/components/tabs/tabs.js");

__webpack_require__(/*! ./components/leaders-sales/leaders-sales */ "./resources/js/components/leaders-sales/leaders-sales.js");

__webpack_require__(/*! ./components/product/moreGoods */ "./resources/js/components/product/moreGoods.js");

__webpack_require__(/*! ./components/card/cardIcons */ "./resources/js/components/card/cardIcons.js");

__webpack_require__(/*! ./components/form/mask/phone-mask */ "./resources/js/components/form/mask/phone-mask.js");

__webpack_require__(/*! ./components/form/label/label-input-focus */ "./resources/js/components/form/label/label-input-focus.js");

__webpack_require__(/*! ./components/form/radio/order-radio-input */ "./resources/js/components/form/radio/order-radio-input.js");

__webpack_require__(/*! ./components/mode-tile/tile */ "./resources/js/components/mode-tile/tile.js");

__webpack_require__(/*! ./components/catalog-filter/brands */ "./resources/js/components/catalog-filter/brands.js");

__webpack_require__(/*! ./components/alerts/close */ "./resources/js/components/alerts/close.js");


 // Datepicker

(function (elem) {
  if (!elem) return;
  var datepicker = new vanillajs_datepicker__WEBPACK_IMPORTED_MODULE_0__["Datepicker"](elem, {
    language: 'ru'
  });
})(document.querySelector('input[name="datePicker"]'));

/***/ }),

/***/ "./resources/js/components/accordion/accordion.js":
/*!********************************************************!*\
  !*** ./resources/js/components/accordion/accordion.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function () {
  var accordions = document.querySelectorAll(".accordion__button-item");
  if (!accordions) return;
  accordions.forEach(function (item) {
    var content = item.nextElementSibling;

    if (item.classList.contains('active')) {
      content.style.maxHeight = content.scrollHeight + "px";
    }

    item.addEventListener('click', function () {
      item.classList.toggle('active');

      if (content.style.maxHeight) {
        content.style.maxHeight = null;
      } else {
        content.style.maxHeight = content.scrollHeight + "px";
      }
    });
  });
})();

/***/ }),

/***/ "./resources/js/components/alerts/close.js":
/*!*************************************************!*\
  !*** ./resources/js/components/alerts/close.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function () {
  var close = document.querySelector('.alert-info__close__icon-close');
  if (!close) return;
  close.addEventListener('click', function () {
    close.closest('.alert').remove();
  });
}();

/***/ }),

/***/ "./resources/js/components/card/btnAdd.js":
/*!************************************************!*\
  !*** ./resources/js/components/card/btnAdd.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.exports = (btnAdd = function btnAdd() {
  var forms = document.querySelectorAll("form.addCart");
  if (!forms) return;
  Array.from(forms, function (item) {
    var formElements = item.elements;
    Array.from(formElements, function (el) {
      if (el.nodeName === "BUTTON") {
        el.addEventListener("click", function (e) {
          e.preventDefault();
          el.classList.add('btn-hide');
          var preload = new GetPreload({
            'wrap': el,
            'class': 'lds-dual-ring'
          });
          xmlHttpRequest(item.action, {
            inc: "++"
          }, function (data) {
            refreshCart(data.cartItemTotalSum, data.cartTotalSum, data.cartCount);
            preload.remove();
          });
        });
      } else {
        return null;
      }
    });
  });
})();

/***/ }),

/***/ "./resources/js/components/card/btnQty.js":
/*!************************************************!*\
  !*** ./resources/js/components/card/btnQty.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var btnQty = function btnQty() {
  var productQty = document.querySelectorAll('.addCart .product-qty');
  if (!productQty) return;
  Array.from(productQty, function (item) {
    var qtyInput = item.querySelector('.product-qty__input');
    item.addEventListener("click", function (e) {
      getQuantity(e.target, qtyInput);
    });
  });
};

window.exports = btnQty();

/***/ }),

/***/ "./resources/js/components/card/cardIcons.js":
/*!***************************************************!*\
  !*** ./resources/js/components/card/cardIcons.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var cardIcons = {
  favorite: null,
  compare: null,
  card: null,
  init: function init() {
    cardIcons.card = document.querySelectorAll(".card__icons");
    if (!cardIcons.card) return;
    Array.from(cardIcons.card, function (item) {
      cardIcons.favorite = item.querySelectorAll(".favorite");
      cardIcons.compare = item.querySelectorAll(".compare");
      Array.from(cardIcons.favorite, function (item) {
        if (item.classList.contains('favorite__active')) {
          item.setAttribute('title', 'Убрать из избранного');
        } else {
          item.setAttribute('title', 'Добавить в избранное');
        }

        item.onclick = function () {
          cardIcons["switch"](this);
        };
      });
      Array.from(cardIcons.compare, function (item) {
        if (item.classList.contains('compare__active')) {
          item.setAttribute('title', 'Убрать из сравнения');
        } else {
          item.setAttribute('title', 'Добавить в сравнение');
        }

        item.onclick = function () {
          cardIcons["switch"](this);
        };
      });
    });
  },
  "switch": function _switch(elem) {
    elem.classList.toggle("".concat(elem.classList[0], "__active"));
    cardIcons.init();
  }
};
window.addEventListener('load', cardIcons.init);

/***/ }),

/***/ "./resources/js/components/card/functions/getPreload.js":
/*!**************************************************************!*\
  !*** ./resources/js/components/card/functions/getPreload.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var _this = this;

/**
 *
 * @param setting
 * @constructor
 */
window.exports = GetPreload = function GetPreload(setting) {
  if (setting.wrap === null) {
    return;
  }

  _this.preloadElement = document.createElement("div");

  _this.preloadElement.classList.add(setting["class"]);

  var parentDiv = setting.wrap.parentNode;
  parentDiv.insertBefore(_this.preloadElement, setting.wrap);

  _this.remove = function () {
    _this.preloadElement.classList.add('hide');

    setTimeout(function () {
      _this.preloadElement.remove();
    }, 300);
  };

  return _this;
};

/***/ }),

/***/ "./resources/js/components/card/functions/qty.js":
/*!*******************************************************!*\
  !*** ./resources/js/components/card/functions/qty.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.exports = getQuantity = function getQuantity(e, input) {
  // Quantity items Products
  var isNumber = function isNumber(val) {
    val = parseInt(val);
    return typeof val === "number" && !isNaN(val) && val !== 0 ? val : 1;
  };

  (function (e, input) {
    var form = input.closest('form');
    var btn = form.querySelector('button.btn-add');
    var cart = form.closest('.cart__product');

    if (e.classList.contains("product-qty__plus")) {
      var preload = GetPreload({
        'wrap': input,
        'class': 'lds-dual-ring'
      });
      input.value = isNumber(input.value) + 1; // add to cart axios

      xmlHttpRequest(form.action, {
        inc: "++"
      }, function (data) {
        refreshCart(data.cartItemTotalSum, data.cartTotalSum, data.cartCount, cart);
        preload.remove();
      });
    } else if (e.classList.contains("product-qty__minus")) {
      if (input.value > 1) {
        var _preload = GetPreload({
          'wrap': input,
          'class': 'lds-dual-ring'
        });

        input.value = isNumber(input.value) - 1; // add to cart axios

        xmlHttpRequest(form.action, {
          inc: "--"
        }, function (data) {
          refreshCart(data.cartItemTotalSum, data.cartTotalSum, data.cartCount, cart);

          _preload.remove();
        });
      } else {
        if (!btn) return;
        btn.classList.remove('btn-hide');
      }
    }

    input.addEventListener("input", function (e) {
      input.value = isNumber(input.value);
      var preload = GetPreload({
        'wrap': input,
        'class': 'lds-dual-ring'
      });
      xmlHttpRequest(form.action, input.value, function (data) {
        preload.remove();
      }); // add to cart axios
    });
  })(e, input);
};

/***/ }),

/***/ "./resources/js/components/cart/refreshCart.js":
/*!*****************************************************!*\
  !*** ./resources/js/components/cart/refreshCart.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.exports = refreshCart = function refreshCart(price, total, badgeCartCount) {
  var cart = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

  if (cart) {
    cart.querySelector('.cart__sum-price').firstChild.data = "".concat(price, " ");
  }

  var CartTotalPrice = document.querySelector('.cart-total-wrap__total-price');

  if (CartTotalPrice) {
    CartTotalPrice.firstChild.data = "".concat(total, " ");
  }

  if (undefined === total) {
    document.querySelector('.cart__icon').classList.remove('active');
    document.querySelector('.sub-header__label.cart-total-sum').innerHTML = 'Корзина';
    document.getElementById('cart-qty').innerHTML = '0';
  } else {
    document.querySelector('.cart__icon').classList.add('active');
    document.querySelector('.sub-header__label.cart-total-sum').innerHTML = "".concat(total, " <span class=\"rub\">\u20BD</span>");
    document.getElementById('cart-qty').innerHTML = badgeCartCount;
  }
};

/***/ }),

/***/ "./resources/js/components/cart/remove.js":
/*!************************************************!*\
  !*** ./resources/js/components/cart/remove.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.exports = (cartRemove = function cartRemove() {
  var forms = document.querySelectorAll("form.del-form");
  if (!forms) return;
  Array.from(forms, function (item) {
    item.addEventListener('submit', function (e) {
      e.preventDefault();
      xmlHttpRequest(item.action, {}, function (data) {
        item.closest('.cart__product').remove();
        refreshCart(data.cartItemTotalSum, data.cartTotalSum, data.cartCount);

        if (data.view) {
          document.querySelector('.flex-center').innerHTML = data.view;
        }
      });
    });
  });
})();

/***/ }),

/***/ "./resources/js/components/catalog-filter/brands.js":
/*!**********************************************************!*\
  !*** ./resources/js/components/catalog-filter/brands.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function () {
  var brandTitle = document.querySelector('.catalog__brand-title');
  if (!brandTitle) return;
  brandTitle.addEventListener('click', function (e) {
    var brandsContainer = document.querySelector('.catalog__brand__wrapper');
    brandsContainer.toggleAttribute('hidden');
  });
}();

/***/ }),

/***/ "./resources/js/components/form/label/label-input-focus.js":
/*!*****************************************************************!*\
  !*** ./resources/js/components/form/label/label-input-focus.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (input) {
  if (!input) return;
  Array.from(input, function (item) {
    if (item.value) {
      item.setAttribute('data-empty', 'false');
    }

    item.addEventListener('input', function (e) {
      e.currentTarget.setAttribute('data-empty', !e.currentTarget.value);
    });
  });
}(document.querySelectorAll('input'));

/***/ }),

/***/ "./resources/js/components/form/mask/phone-mask.js":
/*!*********************************************************!*\
  !*** ./resources/js/components/form/mask/phone-mask.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (maskedInputs) {
  if (!maskedInputs) return;

  var maskInput = function maskInput(input) {
    var mask = "+7 (000) 000-00-00";
    var value = input.value;
    var literalPattern = /[0\*]/;
    var numberPattern = /[0-9]/;
    var newValue = "";

    try {
      var maskLength = mask.length;
      var valueIndex = 0;
      var maskIndex = 0;

      for (; maskIndex < maskLength;) {
        if (maskIndex >= value.length) break;
        if (mask[maskIndex] === "0" && value[valueIndex].match(numberPattern) === null) break; // Found a literal

        while (mask[maskIndex].match(literalPattern) === null) {
          if (value[valueIndex] === mask[maskIndex]) break;
          newValue += mask[maskIndex++];
        }

        newValue += value[valueIndex++];
        maskIndex++;
      }

      input.value = newValue;
    } catch (e) {
      console.log(e);
    }
  };

  Array.from(maskedInputs, function (item) {
    item.addEventListener('input', function () {
      maskInput(item);
    });
  });
}(document.querySelectorAll('.mask-input'));

/***/ }),

/***/ "./resources/js/components/form/radio/order-radio-input.js":
/*!*****************************************************************!*\
  !*** ./resources/js/components/form/radio/order-radio-input.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function () {
  var handleClick = function handleClick(e, list) {
    list.forEach(function (node) {
      node.classList.remove('active');
      node.querySelector('input[type=radio]').checked = false;
    });
    e.currentTarget.classList.add('active');
    e.currentTarget.querySelector('input[type=radio]').checked = true;
  };

  var payments = document.querySelectorAll('.payment-type > div');
  var delivery = document.querySelectorAll('.delivery-type > div');
  var deliveryAdd = document.querySelector('.date-time-delivery');

  if (payments && delivery) {
    payments.forEach(function (item) {
      item.addEventListener('click', function (e) {
        handleClick(e, payments);
      });
    });
    delivery.forEach(function (item) {
      item.addEventListener('click', function (e) {
        handleClick(e, delivery);
        deliveryAdd.toggleAttribute("hidden");
      });
    });
  }
}();

/***/ }),

/***/ "./resources/js/components/homepage-slider/slider.js":
/*!***********************************************************!*\
  !*** ./resources/js/components/homepage-slider/slider.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function () {
  function Carousel(setting) {
    var _this = this;

    if (document.querySelector(setting.wrap) === null) {
      //console.error(`Carousel not fount selector ${setting.wrap}`);
      return;
    }
    /* Scope privates methods and properties */


    var privates = {};
    /* Public methods */
    // Prev slide

    this.prev_slide = function () {
      --privates.opt.position;

      if (privates.opt.position < 0) {
        privates.sel.wrap.classList.add('s-notransition');
        privates.opt.position = privates.opt.max_position - 1;
      }

      privates.sel.wrap.style["transform"] = "translateX(-".concat(privates.opt.position, "00%)");
    }; // Next slide


    this.next_slide = function () {
      ++privates.opt.position;

      if (privates.opt.position >= privates.opt.max_position) {
        privates.opt.position = 0;
      }

      privates.sel.wrap.style["transform"] = "translateX(-".concat(privates.opt.position, "00%)");
    };
    /* Privates properties */


    privates.setting = setting;
    privates.sel = {
      "main": document.querySelector(privates.setting.main),
      "wrap": document.querySelector(privates.setting.wrap),
      "children": document.querySelector(privates.setting.wrap).children,
      "prev": document.querySelector(privates.setting.prev),
      "next": document.querySelector(privates.setting.next)
    };
    privates.opt = {
      "position": 0,
      "max_position": document.querySelector(privates.setting.wrap).children.length
    }; // Control

    if (privates.sel.prev !== null) {
      privates.sel.prev.addEventListener('click', function () {
        _this.prev_slide();
      });
    }

    if (privates.sel.next !== null) {
      privates.sel.next.addEventListener('click', function () {
        _this.next_slide();
      });
    }
  }

  var a = new Carousel({
    "main": ".js-carousel",
    "wrap": ".js-carousel__wrap",
    "prev": ".js-carousel__prev",
    "next": ".js-carousel__next"
  });
})();

/***/ }),

/***/ "./resources/js/components/leaders-sales/leaders-sales.js":
/*!****************************************************************!*\
  !*** ./resources/js/components/leaders-sales/leaders-sales.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function (elem) {
  if (!elem) return;
  var glider = new Glider(elem, {
    //itemWidth: 'auto',
    slidesToShow: 5,
    // auto
    slidesToScroll: 5,
    // auto
    propagateEvent: false,
    draggable: false,
    arrows: {
      prev: '#glider-prev-leaders-sales',
      next: '#glider-next-leaders-sales'
    }
  });
})(document.getElementById('glider-leader-sales'));

/***/ }),

/***/ "./resources/js/components/mode-tile/tile.js":
/*!***************************************************!*\
  !*** ./resources/js/components/mode-tile/tile.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function () {
  var handleClick = function handleClick(e, list) {
    list.forEach(function (node) {
      node.classList.remove('active');
    });
    e.currentTarget.classList.add('active');
  };

  var cartContainer = document.querySelector('.card-container');
  var icons = document.querySelectorAll('.catalog__sorting-icons > div');
  if (!icons) return;
  icons.forEach(function (item) {
    item.addEventListener('click', function (e) {
      handleClick(e, icons);
      cartContainer.classList.toggle('simple-card-mode');
    });
  });
}();

/***/ }),

/***/ "./resources/js/components/product/moreGoods.js":
/*!******************************************************!*\
  !*** ./resources/js/components/product/moreGoods.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./resources/js/components/sticky-header/sticky.js":
/*!*********************************************************!*\
  !*** ./resources/js/components/sticky-header/sticky.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function () {
  /**
   * @returns {number}
   */
  var getDistance = function getDistance(el) {
    return el.offsetTop; // height 33px top-bar
  };

  var subHeader = document.querySelector('.sub-header');
  var logoContainer = document.querySelector('.sub-header__logo-container');
  var catalogMenu = document.querySelector('.page-top-grid .catalog');
  var catalogMenuButton = document.getElementById('catalogMenu');
  var catalogSpoiler = document.querySelector('.catalog-spoiler-btn');
  var stickPoint = getDistance(subHeader);
  var stuck = false; //

  catalogSpoiler.addEventListener('click', function () {
    catalogMenuButton.toggleAttribute('hidden');
  });
  /**
   * Stick menu large button
   * @param item
   */

  var menuLargeButton = function menuLargeButton(item) {
    if (item <= 0) {
      logoContainer.classList.add('large-btn');
    } else {
      logoContainer.classList.remove('large-btn');
      catalogMenuButton.setAttribute('hidden', 'hidden');
    }
  };

  var getStuck = function getStuck() {
    var distance = getDistance(subHeader) - window.pageYOffset;
    var offset = window.pageYOffset; // if isset menu

    var distanceMenu = catalogMenu ? catalogMenu.offsetHeight - stickPoint - window.pageYOffset : null;

    if (distance <= 0 && !stuck) {
      if (!distanceMenu) {
        logoContainer.classList.add('large-btn');
      }

      subHeader.setAttribute("style", "position: fixed; top: 0;");
      stuck = true;
    } else if (stuck && offset <= stickPoint) {
      subHeader.style.position = 'static';
      stuck = false;
    }

    if (distanceMenu) menuLargeButton(distanceMenu);
  }; // Events


  window.onload = getStuck;
  window.onscroll = getStuck;
  /**
   *
   * @param event
   * @param elem
   * @param clickElem
   */

  var toggleShow = function toggleShow(event, elem, clickElem) {
    if (!elem && clickElem) return;

    if (elem.contains(event) || clickElem.contains(event)) {
      return;
    }

    elem.setAttribute('hidden', 'hidden');
  };

  document.addEventListener('click', function (event) {
    toggleShow(event.target, catalogMenuButton, catalogSpoiler);
  });
})();

/***/ }),

/***/ "./resources/js/components/tabs/tabs.js":
/*!**********************************************!*\
  !*** ./resources/js/components/tabs/tabs.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _createForOfIteratorHelper(o) { if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) { var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var it, normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var tab = {
  nav: null,
  // holds all tabs
  txt: null,
  // holds all text containers
  gl: null,
  prev: null,
  next: null,
  init: function init() {
    // tab.init() : init tab interface
    // Get all tabs + contents
    tab.nav = document.querySelectorAll("nav.tabs-nav .tabs-nav__item");
    tab.txt = document.querySelectorAll(".tabs-content .tabs-content__item"); // Error checking

    if (tab.nav.length === 0 || tab.txt.length === 0 || tab.nav.length !== tab.txt.length) {
      return;
    } else {
      // Attach onclick events to navigation tabs
      for (var i = 0; i < tab.nav.length; i++) {
        tab.nav[i].dataset.pos = i;
        tab.nav[i].addEventListener("click", tab["switch"]);
      } // Default - show first tab


      tab.nav[0].classList.add("active");
      tab.txt[0].classList.add("active");
      tab.initGlider();
    }
  },
  initGlider: function initGlider() {
    tab.gl = document.querySelector(".tabs-content__item.active .glider");
    tab.prev = document.querySelector('.tabs-content__item.active .glider-prev');
    tab.next = document.querySelector('.tabs-content__item.active .glider-next');
    tab.glider();
  },
  "switch": function _switch() {
    // tab.switch() : change to another tab
    // Hide all tabs & text
    var _iterator = _createForOfIteratorHelper(tab.nav),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var t = _step.value;
        t.classList.remove("active");
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }

    var _iterator2 = _createForOfIteratorHelper(tab.txt),
        _step2;

    try {
      for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
        var _t = _step2.value;

        _t.classList.remove("active");
      } // Set current tab

    } catch (err) {
      _iterator2.e(err);
    } finally {
      _iterator2.f();
    }

    tab.nav[this.dataset.pos].classList.add("active");
    tab.txt[this.dataset.pos].classList.add("active");
    tab.initGlider();
  },
  glider: function glider() {
    if (!tab.gl) return;
    new Glider(tab.gl, {
      //itemWidth: 'auto',
      slidesToShow: 4,
      // auto
      slidesToScroll: 4,
      // auto
      propagateEvent: false,
      draggable: false,
      arrows: {
        prev: tab.prev,
        next: tab.next
      }
    });
  }
};
window.addEventListener("load", function () {
  tab.init();
});

/***/ }),

/***/ "./resources/js/xmlHttpRequest/xmlHttpRequest.js":
/*!*******************************************************!*\
  !*** ./resources/js/xmlHttpRequest/xmlHttpRequest.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.exports = xmlHttpRequest = function xmlHttpRequest(action, dataForm, callback) {
  callback = callback || function (data) {};

  Axios.post(action, dataForm).then(function (response) {
    callback(response.data);
  })["catch"](function (error) {
    console.log(error);
  });
};

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/css-loader/index.js):\nModuleNotFoundError: Module not found: Error: Can't resolve '../fonts/PTSans/PTSansRegular.eot' in 'E:\\OpenServer\\domains\\zhuravushka\\resources\\sass'\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\webpack\\lib\\Compilation.js:925:10\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\webpack\\lib\\NormalModuleFactory.js:401:22\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\webpack\\lib\\NormalModuleFactory.js:130:21\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\webpack\\lib\\NormalModuleFactory.js:224:22\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\neo-async\\async.js:2830:7\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\neo-async\\async.js:6877:13\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\webpack\\lib\\NormalModuleFactory.js:214:25\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\Resolver.js:213:14\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\Resolver.js:285:5\n    at eval (eval at create (E:\\OpenServer\\domains\\zhuravushka\\node_modules\\tapable\\lib\\HookCodeFactory.js:33:10), <anonymous>:13:1)\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\UnsafeCachePlugin.js:44:7\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\Resolver.js:285:5\n    at eval (eval at create (E:\\OpenServer\\domains\\zhuravushka\\node_modules\\tapable\\lib\\HookCodeFactory.js:33:10), <anonymous>:13:1)\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\Resolver.js:285:5\n    at eval (eval at create (E:\\OpenServer\\domains\\zhuravushka\\node_modules\\tapable\\lib\\HookCodeFactory.js:33:10), <anonymous>:25:1)\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\DescriptionFilePlugin.js:67:43\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\Resolver.js:285:5\n    at eval (eval at create (E:\\OpenServer\\domains\\zhuravushka\\node_modules\\tapable\\lib\\HookCodeFactory.js:33:10), <anonymous>:14:1)\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\Resolver.js:285:5\n    at eval (eval at create (E:\\OpenServer\\domains\\zhuravushka\\node_modules\\tapable\\lib\\HookCodeFactory.js:33:10), <anonymous>:25:1)\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\DescriptionFilePlugin.js:67:43\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\Resolver.js:285:5\n    at eval (eval at create (E:\\OpenServer\\domains\\zhuravushka\\node_modules\\tapable\\lib\\HookCodeFactory.js:33:10), <anonymous>:14:1)\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\Resolver.js:285:5\n    at eval (eval at create (E:\\OpenServer\\domains\\zhuravushka\\node_modules\\tapable\\lib\\HookCodeFactory.js:33:10), <anonymous>:13:1)\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\DirectoryExistsPlugin.js:27:15\n    at E:\\OpenServer\\domains\\zhuravushka\\node_modules\\enhanced-resolve\\lib\\CachedInputFileSystem.js:85:15\n    at processTicksAndRejections (internal/process/task_queues.js:79:11)");

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! E:\OpenServer\domains\zhuravushka\resources\js\app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! E:\OpenServer\domains\zhuravushka\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });
