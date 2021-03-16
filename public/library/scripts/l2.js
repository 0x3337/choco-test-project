/**
 * Designed by Mirsaid Patarov
 * License: MIT license
 * Version: 0.4.0
 * Build: 20C401
 */

(function () {
  'use strict';

  var l2 = function (selector) {
    return new l2.prototype.init(selector);
  };

  l2.key = {
    backspace: 8,
    enter: 13,

    esc: 27,
    
    left: 37,
    up: 38,
    right: 39,
    down: 40,

    get: function (letter, press = false) {
      var l = letter.charCodeAt(0);
      return !press ? l : l.toLowerCase();
    },
  };

  l2.ajax = function (options) {
    var url = options.url;
    var method = options.method || 'GET';
    var contentType = options.contentType || 'text/plain';

    var success = options.success;

    var data = undefined;


    if (options.json) {
      method = 'POST';
      contentType = 'application/json';
      data = JSON.stringify(options.json);
    } else if (options.form) {
      contentType = 'multipart/form-data';
    }

    var request = new XMLHttpRequest();
    request.withCredentials = true;
    request.onreadystatechange = function() {
      if (this.readyState == 4) {
        var resContentType = request.getResponseHeader('Content-type');

        if (/json/.test(resContentType)) {
          success(JSON.parse(this.response));
        } else {
          success(this.response);
        }
      }
    };

    request.open(method, url, true);
    request.setRequestHeader('Content-type', contentType);

    request.send(data);
  };

  l2.hasElement = function (selector) {
    var lElement = l2(selector);

    return {
      else: function (callback) {
        return lElement.size() > 0 ? lElement.get() : callback();
      }
    }
  };

  l2.create = function (...args) {
    var tag = undefined;

    if (args.length >= 1) {
      tag = document.createElement(args[0]);

      if (args.length === 2) {
        if (typeof args[1] === 'string') {
          l2(tag).text(args[1]);
        } else if (typeof args[1] === 'object') {
          for (var k in args[1]) {
            l2(tag).attr(k, args[1][k]);
          }
        }
      } else if (args.length === 3) {
        l2(tag).text(args[1]);

        for (var k in args[2]) {
          l2(tag).attr(k, args[2][k]);
        }
      }
    }

    return tag;
  };

  l2.createFromHTML = function (htmlString) {
    var div = document.createElement('div');
    div.innerHTML = htmlString.trim();
    return div.firstChild; 
  };

  // Set/get cookie
  l2.cookie = function (name, value, expires) {
    if (value === undefined) {
      if (document.cookie.length > 0) {
        var s = document.cookie.indexOf(name + "=");

        if (s != -1) {
          s = s + name.length + 1;
          expires = document.cookie.indexOf(";", s);
          if (expires == -1) expires = document.cookie.length;
          return unescape(document.cookie.substring(s, expires));
        }
      }

      return undefined;
    } else {
      var d = new Date(Date.parse(new Date()) + expires * 1000);
      var expires = "expires="+ d.toUTCString();
      document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }
  };

  // Remove cookie
  l2.removeCookie = function (name) {
    if (getCookie(name) !== undefined) {
      document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
  };

  var init = l2.prototype.init = function (selector) {
    if (selector) {
      if (typeof selector === 'object') {
        this.element = selector;
      } else {
        var allElements = document.querySelectorAll(selector);
        if (allElements.length === 1) {
          this.element = allElements[0];
        } else {
          this.elements = allElements;
        }
      }
    }
  };

  l2.fn = init.prototype = {
    size: function () {
      if (this.elements) {
        return this.elements.length;
      } else {
        return this.element ? 1 : 0;
      }
    },

    // Get element
    get: function (index) {
      if (this.elements) {
        return typeof index === 'number' ? this.elements[index] : this.elements;
      } else {
        return this.element;
      }
    },

    // Finds in the parent element
    find: function (selector) {
      if (typeof selector === 'string') {
        if (this.elements) {
          // TODO
        } else {
          var allElements = this.element.querySelectorAll(selector);
          if (allElements.length === 1) {
            this.element = allElements[0];
          } else {
            this.elements = allElements;
            this.element = undefined;
          }
        }
      }

      return this;
    },

    // Set/get attribute
    attr: function (name, value) {
      if (value === undefined) return this.element.getAttribute(name);
      this.element.setAttribute(name, value);
    },

    // Remove attribute
    removeAttr: function (...name) {
      for (var i = 0; i < name.length; i++) {
        this.element.removeAttribute(name[i]);
      }
    },

    // On some event
    on: function (options, listener) {
      if (this.elements) {
        for (var i = 0; i < this.elements.length; i++) {
          if (typeof options === 'string') {
            this.elements[i].addEventListener(options, listener);
          } else if (typeof options === 'object') {
            this.elements[i].addEventListener(options.event, function (event) {
              listener(event, options.data);
            });
          }
        }
      } else {
        if (typeof options === 'string') {
          this.element.addEventListener(options, listener);
        } else if (typeof options === 'object') {
          this.element.addEventListener(options.event, function (event) {
            listener(event, options.data);
          });
        }
      }

      return this;
    },

    goto: function (top = 0) {
      if (this.element) {
        var position = this.element.getBoundingClientRect();
        window.scrollTo(position.left, position.top + top);
      }

      return this;
    },

    // Add class
    addClass: function (...args) {
      if (this.elements) {
        for (var i = 0; i < this.elements.length; i++) {
          this.elements[i].classList.add(...args);
        }
      } else this.element.classList.add(...args);

      return this;
    },

    // Remove class
    removeClass: function (...args) {
      if (this.elements) {
        for (var i = 0; i < this.elements.length; i++) {
          if (args.length > 0) this.elements[i].classList.remove(...args);
          else this.elements[i].className = '';
        }
      } else {
        if (args.length > 0) this.element.classList.remove(...args);
        else this.element.className = '';
      }

      return this;
    },

    // If element contains class return true
    hasClass: function (name) {
      if (this.elements) {
        for (var i = 0; i < this.elements.length; i++) {
          if (this.element.classList.contains(name)) return true;
        }

        return false;
      } else {
        return this.element.classList.contains(name);
      }
    },

    // Get value
    val: function () {
      if (this.element.nodeName.match(/input|select|textarea/i)) {
        return this.element.value;
      } else undefined;
    },

    // Set/get text
    text: function (text, defaultText = '') {
      var str = text || defaultText;

      if (str !== undefined && str !== null) {
        if (typeof str === 'string' || typeof str === 'number' || typeof str === 'boolean') {
          if (this.elements) {
            for (var i = 0; i < this.elements.length; i++) {
              this.elements[i].innerText = str;
            }
          } else {
            this.element.innerText = str;
          }
        }
      } else if (!this.elements) {
        return this.element.innerText;
      }
    },

    html: function (text) {
      if (text) {
        if (typeof text === 'string' || typeof text === 'number' || typeof text === 'boolean') {
          if (this.elements) {
            for (var i = 0; i < this.elements.length; i++) {
              this.elements[i].innerHTML = text;
            }
          } else {
            this.element.innerHTML = text;
          }
        }
      } else {
        return this.element.innerHTML;
      }
    },

    contains: function (element) {
      if (this.elements) {
        for (var i = 0; i < this.elements.length; i++) {
          if (this.elements[i].contains(element)) {
            return true;
          }
        }

        return false;
      } else {
        return this.element.contains(element);
      }
    },

    // Append child
    append: function (ch) {
      if (this.elements) {
        for (var i = 0; i < this.elements.length; i++) {
          this.elements[i].appendChild(ch);
        }
      } else this.element.appendChild(ch);

      return this;
    },

    // Detach child
    detach: function (ch) {
      if (ch) {
        if (this.elements) {
          for (var i = 0; i < this.elements.length; i++) {
            this.elements[i].removeChild(ch);
          }
        } else this.element.removeChild(ch);
      } else this.text('');

      return this;
    },

    delete: function () {
      if (this.elements) {
        for (var i = 0; i < this.elements.length; i++) {
          this.elements[i].parentNode.removeChild(this.elements[i]);
        }
      } else this.element.parentNode.removeChild(this.element);
    },
  }

  window.l2 = l2;
})();