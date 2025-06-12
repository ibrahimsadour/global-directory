function or(e, t) {
    return function() {
        return e.apply(t, arguments)
    }
}
const {
    toString: Mi
} = Object.prototype, {
    getPrototypeOf: $n
} = Object, xe = (e => t => {
    const n = Mi.call(t);
    return e[n] || (e[n] = n.slice(8, -1).toLowerCase())
})(Object.create(null)), X = e => (e = e.toLowerCase(), t => xe(t) === e), Pe = e => t => typeof t === e, {
    isArray: Ut
} = Array, ne = Pe("undefined");

function ki(e) {
    return e !== null && !ne(e) && e.constructor !== null && !ne(e.constructor) && F(e.constructor.isBuffer) && e.constructor.isBuffer(e)
}
const ar = X("ArrayBuffer");

function Vi(e) {
    let t;
    return typeof ArrayBuffer < "u" && ArrayBuffer.isView ? t = ArrayBuffer.isView(e) : t = e && e.buffer && ar(e.buffer), t
}
const Fi = Pe("string"),
    F = Pe("function"),
    cr = Pe("number"),
    Me = e => e !== null && typeof e == "object",
    Hi = e => e === !0 || e === !1,
    Te = e => {
        if (xe(e) !== "object") return !1;
        const t = $n(e);
        return (t === null || t === Object.prototype || Object.getPrototypeOf(t) === null) && !(Symbol.toStringTag in e) && !(Symbol.iterator in e)
    },
    Bi = X("Date"),
    ji = X("File"),
    Ui = X("Blob"),
    Wi = X("FileList"),
    Ki = e => Me(e) && F(e.pipe),
    qi = e => {
        let t;
        return e && (typeof FormData == "function" && e instanceof FormData || F(e.append) && ((t = xe(e)) === "formdata" || t === "object" && F(e.toString) && e.toString() === "[object FormData]"))
    },
    Yi = X("URLSearchParams"),
    [zi, Gi, Xi, Ji] = ["ReadableStream", "Request", "Response", "Headers"].map(X),
    Qi = e => e.trim ? e.trim() : e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "");

function re(e, t, {
    allOwnKeys: n = !1
} = {}) {
    if (e === null || typeof e > "u") return;
    let s, r;
    if (typeof e != "object" && (e = [e]), Ut(e))
        for (s = 0, r = e.length; s < r; s++) t.call(null, e[s], s, e);
    else {
        const i = n ? Object.getOwnPropertyNames(e) : Object.keys(e),
            o = i.length;
        let a;
        for (s = 0; s < o; s++) a = i[s], t.call(null, e[a], a, e)
    }
}

function lr(e, t) {
    t = t.toLowerCase();
    const n = Object.keys(e);
    let s = n.length,
        r;
    for (; s-- > 0;)
        if (r = n[s], t === r.toLowerCase()) return r;
    return null
}
const bt = typeof globalThis < "u" ? globalThis : typeof self < "u" ? self : typeof window < "u" ? window : global,
    ur = e => !ne(e) && e !== bt;

function gn() {
    const {
        caseless: e
    } = ur(this) && this || {}, t = {}, n = (s, r) => {
        const i = e && lr(t, r) || r;
        Te(t[i]) && Te(s) ? t[i] = gn(t[i], s) : Te(s) ? t[i] = gn({}, s) : Ut(s) ? t[i] = s.slice() : t[i] = s
    };
    for (let s = 0, r = arguments.length; s < r; s++) arguments[s] && re(arguments[s], n);
    return t
}
const Zi = (e, t, n, {
        allOwnKeys: s
    } = {}) => (re(t, (r, i) => {
        n && F(r) ? e[i] = or(r, n) : e[i] = r
    }, {
        allOwnKeys: s
    }), e),
    to = e => (e.charCodeAt(0) === 65279 && (e = e.slice(1)), e),
    eo = (e, t, n, s) => {
        e.prototype = Object.create(t.prototype, s), e.prototype.constructor = e, Object.defineProperty(e, "super", {
            value: t.prototype
        }), n && Object.assign(e.prototype, n)
    },
    no = (e, t, n, s) => {
        let r, i, o;
        const a = {};
        if (t = t || {}, e == null) return t;
        do {
            for (r = Object.getOwnPropertyNames(e), i = r.length; i-- > 0;) o = r[i], (!s || s(o, e, t)) && !a[o] && (t[o] = e[o], a[o] = !0);
            e = n !== !1 && $n(e)
        } while (e && (!n || n(e, t)) && e !== Object.prototype);
        return t
    },
    so = (e, t, n) => {
        e = String(e), (n === void 0 || n > e.length) && (n = e.length), n -= t.length;
        const s = e.indexOf(t, n);
        return s !== -1 && s === n
    },
    ro = e => {
        if (!e) return null;
        if (Ut(e)) return e;
        let t = e.length;
        if (!cr(t)) return null;
        const n = new Array(t);
        for (; t-- > 0;) n[t] = e[t];
        return n
    },
    io = (e => t => e && t instanceof e)(typeof Uint8Array < "u" && $n(Uint8Array)),
    oo = (e, t) => {
        const s = (e && e[Symbol.iterator]).call(e);
        let r;
        for (;
            (r = s.next()) && !r.done;) {
            const i = r.value;
            t.call(e, i[0], i[1])
        }
    },
    ao = (e, t) => {
        let n;
        const s = [];
        for (;
            (n = e.exec(t)) !== null;) s.push(n);
        return s
    },
    co = X("HTMLFormElement"),
    lo = e => e.toLowerCase().replace(/[-_\s]([a-z\d])(\w*)/g, function(n, s, r) {
        return s.toUpperCase() + r
    }),
    us = (({
        hasOwnProperty: e
    }) => (t, n) => e.call(t, n))(Object.prototype),
    uo = X("RegExp"),
    fr = (e, t) => {
        const n = Object.getOwnPropertyDescriptors(e),
            s = {};
        re(n, (r, i) => {
            let o;
            (o = t(r, i, e)) !== !1 && (s[i] = o || r)
        }), Object.defineProperties(e, s)
    },
    fo = e => {
        fr(e, (t, n) => {
            if (F(e) && ["arguments", "caller", "callee"].indexOf(n) !== -1) return !1;
            const s = e[n];
            if (F(s)) {
                if (t.enumerable = !1, "writable" in t) {
                    t.writable = !1;
                    return
                }
                t.set || (t.set = () => {
                    throw Error("Can not rewrite read-only method '" + n + "'")
                })
            }
        })
    },
    ho = (e, t) => {
        const n = {},
            s = r => {
                r.forEach(i => {
                    n[i] = !0
                })
            };
        return Ut(e) ? s(e) : s(String(e).split(t)), n
    },
    po = () => {},
    mo = (e, t) => e != null && Number.isFinite(e = +e) ? e : t,
    Je = "abcdefghijklmnopqrstuvwxyz",
    fs = "0123456789",
    dr = {
        DIGIT: fs,
        ALPHA: Je,
        ALPHA_DIGIT: Je + Je.toUpperCase() + fs
    },
    _o = (e = 16, t = dr.ALPHA_DIGIT) => {
        let n = "";
        const {
            length: s
        } = t;
        for (; e--;) n += t[Math.random() * s | 0];
        return n
    };

function go(e) {
    return !!(e && F(e.append) && e[Symbol.toStringTag] === "FormData" && e[Symbol.iterator])
}
const Eo = e => {
        const t = new Array(10),
            n = (s, r) => {
                if (Me(s)) {
                    if (t.indexOf(s) >= 0) return;
                    if (!("toJSON" in s)) {
                        t[r] = s;
                        const i = Ut(s) ? [] : {};
                        return re(s, (o, a) => {
                            const l = n(o, r + 1);
                            !ne(l) && (i[a] = l)
                        }), t[r] = void 0, i
                    }
                }
                return s
            };
        return n(e, 0)
    },
    bo = X("AsyncFunction"),
    vo = e => e && (Me(e) || F(e)) && F(e.then) && F(e.catch),
    hr = ((e, t) => e ? setImmediate : t ? ((n, s) => (bt.addEventListener("message", ({
        source: r,
        data: i
    }) => {
        r === bt && i === n && s.length && s.shift()()
    }, !1), r => {
        s.push(r), bt.postMessage(n, "*")
    }))(`axios@${Math.random()}`, []) : n => setTimeout(n))(typeof setImmediate == "function", F(bt.postMessage)),
    yo = typeof queueMicrotask < "u" ? queueMicrotask.bind(bt) : typeof process < "u" && process.nextTick || hr,
    f = {
        isArray: Ut,
        isArrayBuffer: ar,
        isBuffer: ki,
        isFormData: qi,
        isArrayBufferView: Vi,
        isString: Fi,
        isNumber: cr,
        isBoolean: Hi,
        isObject: Me,
        isPlainObject: Te,
        isReadableStream: zi,
        isRequest: Gi,
        isResponse: Xi,
        isHeaders: Ji,
        isUndefined: ne,
        isDate: Bi,
        isFile: ji,
        isBlob: Ui,
        isRegExp: uo,
        isFunction: F,
        isStream: Ki,
        isURLSearchParams: Yi,
        isTypedArray: io,
        isFileList: Wi,
        forEach: re,
        merge: gn,
        extend: Zi,
        trim: Qi,
        stripBOM: to,
        inherits: eo,
        toFlatObject: no,
        kindOf: xe,
        kindOfTest: X,
        endsWith: so,
        toArray: ro,
        forEachEntry: oo,
        matchAll: ao,
        isHTMLForm: co,
        hasOwnProperty: us,
        hasOwnProp: us,
        reduceDescriptors: fr,
        freezeMethods: fo,
        toObjectSet: ho,
        toCamelCase: lo,
        noop: po,
        toFiniteNumber: mo,
        findKey: lr,
        global: bt,
        isContextDefined: ur,
        ALPHABET: dr,
        generateString: _o,
        isSpecCompliantForm: go,
        toJSONObject: Eo,
        isAsyncFn: bo,
        isThenable: vo,
        setImmediate: hr,
        asap: yo
    };

function A(e, t, n, s, r) {
    Error.call(this), Error.captureStackTrace ? Error.captureStackTrace(this, this.constructor) : this.stack = new Error().stack, this.message = e, this.name = "AxiosError", t && (this.code = t), n && (this.config = n), s && (this.request = s), r && (this.response = r, this.status = r.status ? r.status : null)
}
f.inherits(A, Error, {
    toJSON: function() {
        return {
            message: this.message,
            name: this.name,
            description: this.description,
            number: this.number,
            fileName: this.fileName,
            lineNumber: this.lineNumber,
            columnNumber: this.columnNumber,
            stack: this.stack,
            config: f.toJSONObject(this.config),
            code: this.code,
            status: this.status
        }
    }
});
const pr = A.prototype,
    mr = {};
["ERR_BAD_OPTION_VALUE", "ERR_BAD_OPTION", "ECONNABORTED", "ETIMEDOUT", "ERR_NETWORK", "ERR_FR_TOO_MANY_REDIRECTS", "ERR_DEPRECATED", "ERR_BAD_RESPONSE", "ERR_BAD_REQUEST", "ERR_CANCELED", "ERR_NOT_SUPPORT", "ERR_INVALID_URL"].forEach(e => {
    mr[e] = {
        value: e
    }
});
Object.defineProperties(A, mr);
Object.defineProperty(pr, "isAxiosError", {
    value: !0
});
A.from = (e, t, n, s, r, i) => {
    const o = Object.create(pr);
    return f.toFlatObject(e, o, function(l) {
        return l !== Error.prototype
    }, a => a !== "isAxiosError"), A.call(o, e.message, t, n, s, r), o.cause = e, o.name = e.name, i && Object.assign(o, i), o
};
const Ao = null;

function En(e) {
    return f.isPlainObject(e) || f.isArray(e)
}

function _r(e) {
    return f.endsWith(e, "[]") ? e.slice(0, -2) : e
}

function ds(e, t, n) {
    return e ? e.concat(t).map(function(r, i) {
        return r = _r(r), !n && i ? "[" + r + "]" : r
    }).join(n ? "." : "") : t
}

function To(e) {
    return f.isArray(e) && !e.some(En)
}
const wo = f.toFlatObject(f, {}, null, function(t) {
    return /^is[A-Z]/.test(t)
});

function ke(e, t, n) {
    if (!f.isObject(e)) throw new TypeError("target must be an object");
    t = t || new FormData, n = f.toFlatObject(n, {
        metaTokens: !0,
        dots: !1,
        indexes: !1
    }, !1, function(_, p) {
        return !f.isUndefined(p[_])
    });
    const s = n.metaTokens,
        r = n.visitor || c,
        i = n.dots,
        o = n.indexes,
        l = (n.Blob || typeof Blob < "u" && Blob) && f.isSpecCompliantForm(t);
    if (!f.isFunction(r)) throw new TypeError("visitor must be a function");

    function u(m) {
        if (m === null) return "";
        if (f.isDate(m)) return m.toISOString();
        if (!l && f.isBlob(m)) throw new A("Blob is not supported. Use a Buffer instead.");
        return f.isArrayBuffer(m) || f.isTypedArray(m) ? l && typeof Blob == "function" ? new Blob([m]) : Buffer.from(m) : m
    }

    function c(m, _, p) {
        let T = m;
        if (m && !p && typeof m == "object") {
            if (f.endsWith(_, "{}")) _ = s ? _ : _.slice(0, -2), m = JSON.stringify(m);
            else if (f.isArray(m) && To(m) || (f.isFileList(m) || f.endsWith(_, "[]")) && (T = f.toArray(m))) return _ = _r(_), T.forEach(function(y, b) {
                !(f.isUndefined(y) || y === null) && t.append(o === !0 ? ds([_], b, i) : o === null ? _ : _ + "[]", u(y))
            }), !1
        }
        return En(m) ? !0 : (t.append(ds(p, _, i), u(m)), !1)
    }
    const h = [],
        E = Object.assign(wo, {
            defaultVisitor: c,
            convertValue: u,
            isVisitable: En
        });

    function g(m, _) {
        if (!f.isUndefined(m)) {
            if (h.indexOf(m) !== -1) throw Error("Circular reference detected in " + _.join("."));
            h.push(m), f.forEach(m, function(T, O) {
                (!(f.isUndefined(T) || T === null) && r.call(t, T, f.isString(O) ? O.trim() : O, _, E)) === !0 && g(T, _ ? _.concat(O) : [O])
            }), h.pop()
        }
    }
    if (!f.isObject(e)) throw new TypeError("data must be an object");
    return g(e), t
}

function hs(e) {
    const t = {
        "!": "%21",
        "'": "%27",
        "(": "%28",
        ")": "%29",
        "~": "%7E",
        "%20": "+",
        "%00": "\0"
    };
    return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g, function(s) {
        return t[s]
    })
}

function In(e, t) {
    this._pairs = [], e && ke(e, this, t)
}
const gr = In.prototype;
gr.append = function(t, n) {
    this._pairs.push([t, n])
};
gr.toString = function(t) {
    const n = t ? function(s) {
        return t.call(this, s, hs)
    } : hs;
    return this._pairs.map(function(r) {
        return n(r[0]) + "=" + n(r[1])
    }, "").join("&")
};

function Oo(e) {
    return encodeURIComponent(e).replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%20/g, "+").replace(/%5B/gi, "[").replace(/%5D/gi, "]")
}

function Er(e, t, n) {
    if (!t) return e;
    const s = n && n.encode || Oo,
        r = n && n.serialize;
    let i;
    if (r ? i = r(t, n) : i = f.isURLSearchParams(t) ? t.toString() : new In(t, n).toString(s), i) {
        const o = e.indexOf("#");
        o !== -1 && (e = e.slice(0, o)), e += (e.indexOf("?") === -1 ? "?" : "&") + i
    }
    return e
}
class ps {
    constructor() {
        this.handlers = []
    }
    use(t, n, s) {
        return this.handlers.push({
            fulfilled: t,
            rejected: n,
            synchronous: s ? s.synchronous : !1,
            runWhen: s ? s.runWhen : null
        }), this.handlers.length - 1
    }
    eject(t) {
        this.handlers[t] && (this.handlers[t] = null)
    }
    clear() {
        this.handlers && (this.handlers = [])
    }
    forEach(t) {
        f.forEach(this.handlers, function(s) {
            s !== null && t(s)
        })
    }
}
const br = {
        silentJSONParsing: !0,
        forcedJSONParsing: !0,
        clarifyTimeoutError: !1
    },
    So = typeof URLSearchParams < "u" ? URLSearchParams : In,
    Co = typeof FormData < "u" ? FormData : null,
    No = typeof Blob < "u" ? Blob : null,
    Do = {
        isBrowser: !0,
        classes: {
            URLSearchParams: So,
            FormData: Co,
            Blob: No
        },
        protocols: ["http", "https", "file", "blob", "url", "data"]
    },
    xn = typeof window < "u" && typeof document < "u",
    bn = typeof navigator == "object" && navigator || void 0,
    Lo = xn && (!bn || ["ReactNative", "NativeScript", "NS"].indexOf(bn.product) < 0),
    Ro = typeof WorkerGlobalScope < "u" && self instanceof WorkerGlobalScope && typeof self.importScripts == "function",
    $o = xn && window.location.href || "http://localhost",
    Io = Object.freeze(Object.defineProperty({
        __proto__: null,
        hasBrowserEnv: xn,
        hasStandardBrowserEnv: Lo,
        hasStandardBrowserWebWorkerEnv: Ro,
        navigator: bn,
        origin: $o
    }, Symbol.toStringTag, {
        value: "Module"
    })),
    H = {
        ...Io,
        ...Do
    };

function xo(e, t) {
    return ke(e, new H.classes.URLSearchParams, Object.assign({
        visitor: function(n, s, r, i) {
            return H.isNode && f.isBuffer(n) ? (this.append(s, n.toString("base64")), !1) : i.defaultVisitor.apply(this, arguments)
        }
    }, t))
}

function Po(e) {
    return f.matchAll(/\w+|\[(\w*)]/g, e).map(t => t[0] === "[]" ? "" : t[1] || t[0])
}

function Mo(e) {
    const t = {},
        n = Object.keys(e);
    let s;
    const r = n.length;
    let i;
    for (s = 0; s < r; s++) i = n[s], t[i] = e[i];
    return t
}

function vr(e) {
    function t(n, s, r, i) {
        let o = n[i++];
        if (o === "__proto__") return !0;
        const a = Number.isFinite(+o),
            l = i >= n.length;
        return o = !o && f.isArray(r) ? r.length : o, l ? (f.hasOwnProp(r, o) ? r[o] = [r[o], s] : r[o] = s, !a) : ((!r[o] || !f.isObject(r[o])) && (r[o] = []), t(n, s, r[o], i) && f.isArray(r[o]) && (r[o] = Mo(r[o])), !a)
    }
    if (f.isFormData(e) && f.isFunction(e.entries)) {
        const n = {};
        return f.forEachEntry(e, (s, r) => {
            t(Po(s), r, n, 0)
        }), n
    }
    return null
}

function ko(e, t, n) {
    if (f.isString(e)) try {
        return (t || JSON.parse)(e), f.trim(e)
    } catch (s) {
        if (s.name !== "SyntaxError") throw s
    }
    return (n || JSON.stringify)(e)
}
const ie = {
    transitional: br,
    adapter: ["xhr", "http", "fetch"],
    transformRequest: [function(t, n) {
        const s = n.getContentType() || "",
            r = s.indexOf("application/json") > -1,
            i = f.isObject(t);
        if (i && f.isHTMLForm(t) && (t = new FormData(t)), f.isFormData(t)) return r ? JSON.stringify(vr(t)) : t;
        if (f.isArrayBuffer(t) || f.isBuffer(t) || f.isStream(t) || f.isFile(t) || f.isBlob(t) || f.isReadableStream(t)) return t;
        if (f.isArrayBufferView(t)) return t.buffer;
        if (f.isURLSearchParams(t)) return n.setContentType("application/x-www-form-urlencoded;charset=utf-8", !1), t.toString();
        let a;
        if (i) {
            if (s.indexOf("application/x-www-form-urlencoded") > -1) return xo(t, this.formSerializer).toString();
            if ((a = f.isFileList(t)) || s.indexOf("multipart/form-data") > -1) {
                const l = this.env && this.env.FormData;
                return ke(a ? {
                    "files[]": t
                } : t, l && new l, this.formSerializer)
            }
        }
        return i || r ? (n.setContentType("application/json", !1), ko(t)) : t
    }],
    transformResponse: [function(t) {
        const n = this.transitional || ie.transitional,
            s = n && n.forcedJSONParsing,
            r = this.responseType === "json";
        if (f.isResponse(t) || f.isReadableStream(t)) return t;
        if (t && f.isString(t) && (s && !this.responseType || r)) {
            const o = !(n && n.silentJSONParsing) && r;
            try {
                return JSON.parse(t)
            } catch (a) {
                if (o) throw a.name === "SyntaxError" ? A.from(a, A.ERR_BAD_RESPONSE, this, null, this.response) : a
            }
        }
        return t
    }],
    timeout: 0,
    xsrfCookieName: "XSRF-TOKEN",
    xsrfHeaderName: "X-XSRF-TOKEN",
    maxContentLength: -1,
    maxBodyLength: -1,
    env: {
        FormData: H.classes.FormData,
        Blob: H.classes.Blob
    },
    validateStatus: function(t) {
        return t >= 200 && t < 300
    },
    headers: {
        common: {
            Accept: "application/json, text/plain, */*",
            "Content-Type": void 0
        }
    }
};
f.forEach(["delete", "get", "head", "post", "put", "patch"], e => {
    ie.headers[e] = {}
});
const Vo = f.toObjectSet(["age", "authorization", "content-length", "content-type", "etag", "expires", "from", "host", "if-modified-since", "if-unmodified-since", "last-modified", "location", "max-forwards", "proxy-authorization", "referer", "retry-after", "user-agent"]),
    Fo = e => {
        const t = {};
        let n, s, r;
        return e && e.split(`
`).forEach(function(o) {
            r = o.indexOf(":"), n = o.substring(0, r).trim().toLowerCase(), s = o.substring(r + 1).trim(), !(!n || t[n] && Vo[n]) && (n === "set-cookie" ? t[n] ? t[n].push(s) : t[n] = [s] : t[n] = t[n] ? t[n] + ", " + s : s)
        }), t
    },
    ms = Symbol("internals");

function Jt(e) {
    return e && String(e).trim().toLowerCase()
}

function we(e) {
    return e === !1 || e == null ? e : f.isArray(e) ? e.map(we) : String(e)
}

function Ho(e) {
    const t = Object.create(null),
        n = /([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;
    let s;
    for (; s = n.exec(e);) t[s[1]] = s[2];
    return t
}
const Bo = e => /^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim());

function Qe(e, t, n, s, r) {
    if (f.isFunction(s)) return s.call(this, t, n);
    if (r && (t = n), !!f.isString(t)) {
        if (f.isString(s)) return t.indexOf(s) !== -1;
        if (f.isRegExp(s)) return s.test(t)
    }
}

function jo(e) {
    return e.trim().toLowerCase().replace(/([a-z\d])(\w*)/g, (t, n, s) => n.toUpperCase() + s)
}

function Uo(e, t) {
    const n = f.toCamelCase(" " + t);
    ["get", "set", "has"].forEach(s => {
        Object.defineProperty(e, s + n, {
            value: function(r, i, o) {
                return this[s].call(this, t, r, i, o)
            },
            configurable: !0
        })
    })
}
class k {
    constructor(t) {
        t && this.set(t)
    }
    set(t, n, s) {
        const r = this;

        function i(a, l, u) {
            const c = Jt(l);
            if (!c) throw new Error("header name must be a non-empty string");
            const h = f.findKey(r, c);
            (!h || r[h] === void 0 || u === !0 || u === void 0 && r[h] !== !1) && (r[h || l] = we(a))
        }
        const o = (a, l) => f.forEach(a, (u, c) => i(u, c, l));
        if (f.isPlainObject(t) || t instanceof this.constructor) o(t, n);
        else if (f.isString(t) && (t = t.trim()) && !Bo(t)) o(Fo(t), n);
        else if (f.isHeaders(t))
            for (const [a, l] of t.entries()) i(l, a, s);
        else t != null && i(n, t, s);
        return this
    }
    get(t, n) {
        if (t = Jt(t), t) {
            const s = f.findKey(this, t);
            if (s) {
                const r = this[s];
                if (!n) return r;
                if (n === !0) return Ho(r);
                if (f.isFunction(n)) return n.call(this, r, s);
                if (f.isRegExp(n)) return n.exec(r);
                throw new TypeError("parser must be boolean|regexp|function")
            }
        }
    }
    has(t, n) {
        if (t = Jt(t), t) {
            const s = f.findKey(this, t);
            return !!(s && this[s] !== void 0 && (!n || Qe(this, this[s], s, n)))
        }
        return !1
    }
    delete(t, n) {
        const s = this;
        let r = !1;

        function i(o) {
            if (o = Jt(o), o) {
                const a = f.findKey(s, o);
                a && (!n || Qe(s, s[a], a, n)) && (delete s[a], r = !0)
            }
        }
        return f.isArray(t) ? t.forEach(i) : i(t), r
    }
    clear(t) {
        const n = Object.keys(this);
        let s = n.length,
            r = !1;
        for (; s--;) {
            const i = n[s];
            (!t || Qe(this, this[i], i, t, !0)) && (delete this[i], r = !0)
        }
        return r
    }
    normalize(t) {
        const n = this,
            s = {};
        return f.forEach(this, (r, i) => {
            const o = f.findKey(s, i);
            if (o) {
                n[o] = we(r), delete n[i];
                return
            }
            const a = t ? jo(i) : String(i).trim();
            a !== i && delete n[i], n[a] = we(r), s[a] = !0
        }), this
    }
    concat(...t) {
        return this.constructor.concat(this, ...t)
    }
    toJSON(t) {
        const n = Object.create(null);
        return f.forEach(this, (s, r) => {
            s != null && s !== !1 && (n[r] = t && f.isArray(s) ? s.join(", ") : s)
        }), n
    } [Symbol.iterator]() {
        return Object.entries(this.toJSON())[Symbol.iterator]()
    }
    toString() {
        return Object.entries(this.toJSON()).map(([t, n]) => t + ": " + n).join(`
`)
    }
    get[Symbol.toStringTag]() {
        return "AxiosHeaders"
    }
    static from(t) {
        return t instanceof this ? t : new this(t)
    }
    static concat(t, ...n) {
        const s = new this(t);
        return n.forEach(r => s.set(r)), s
    }
    static accessor(t) {
        const s = (this[ms] = this[ms] = {
                accessors: {}
            }).accessors,
            r = this.prototype;

        function i(o) {
            const a = Jt(o);
            s[a] || (Uo(r, o), s[a] = !0)
        }
        return f.isArray(t) ? t.forEach(i) : i(t), this
    }
}
k.accessor(["Content-Type", "Content-Length", "Accept", "Accept-Encoding", "User-Agent", "Authorization"]);
f.reduceDescriptors(k.prototype, ({
    value: e
}, t) => {
    let n = t[0].toUpperCase() + t.slice(1);
    return {
        get: () => e,
        set(s) {
            this[n] = s
        }
    }
});
f.freezeMethods(k);

function Ze(e, t) {
    const n = this || ie,
        s = t || n,
        r = k.from(s.headers);
    let i = s.data;
    return f.forEach(e, function(a) {
        i = a.call(n, i, r.normalize(), t ? t.status : void 0)
    }), r.normalize(), i
}

function yr(e) {
    return !!(e && e.__CANCEL__)
}

function Wt(e, t, n) {
    A.call(this, e ?? "canceled", A.ERR_CANCELED, t, n), this.name = "CanceledError"
}
f.inherits(Wt, A, {
    __CANCEL__: !0
});

function Ar(e, t, n) {
    const s = n.config.validateStatus;
    !n.status || !s || s(n.status) ? e(n) : t(new A("Request failed with status code " + n.status, [A.ERR_BAD_REQUEST, A.ERR_BAD_RESPONSE][Math.floor(n.status / 100) - 4], n.config, n.request, n))
}

function Wo(e) {
    const t = /^([-+\w]{1,25})(:?\/\/|:)/.exec(e);
    return t && t[1] || ""
}

function Ko(e, t) {
    e = e || 10;
    const n = new Array(e),
        s = new Array(e);
    let r = 0,
        i = 0,
        o;
    return t = t !== void 0 ? t : 1e3,
        function(l) {
            const u = Date.now(),
                c = s[i];
            o || (o = u), n[r] = l, s[r] = u;
            let h = i,
                E = 0;
            for (; h !== r;) E += n[h++], h = h % e;
            if (r = (r + 1) % e, r === i && (i = (i + 1) % e), u - o < t) return;
            const g = c && u - c;
            return g ? Math.round(E * 1e3 / g) : void 0
        }
}

function qo(e, t) {
    let n = 0,
        s = 1e3 / t,
        r, i;
    const o = (u, c = Date.now()) => {
        n = c, r = null, i && (clearTimeout(i), i = null), e.apply(null, u)
    };
    return [(...u) => {
        const c = Date.now(),
            h = c - n;
        h >= s ? o(u, c) : (r = u, i || (i = setTimeout(() => {
            i = null, o(r)
        }, s - h)))
    }, () => r && o(r)]
}
const Ne = (e, t, n = 3) => {
        let s = 0;
        const r = Ko(50, 250);
        return qo(i => {
            const o = i.loaded,
                a = i.lengthComputable ? i.total : void 0,
                l = o - s,
                u = r(l),
                c = o <= a;
            s = o;
            const h = {
                loaded: o,
                total: a,
                progress: a ? o / a : void 0,
                bytes: l,
                rate: u || void 0,
                estimated: u && a && c ? (a - o) / u : void 0,
                event: i,
                lengthComputable: a != null,
                [t ? "download" : "upload"]: !0
            };
            e(h)
        }, n)
    },
    _s = (e, t) => {
        const n = e != null;
        return [s => t[0]({
            lengthComputable: n,
            total: e,
            loaded: s
        }), t[1]]
    },
    gs = e => (...t) => f.asap(() => e(...t)),
    Yo = H.hasStandardBrowserEnv ? function() {
        const t = H.navigator && /(msie|trident)/i.test(H.navigator.userAgent),
            n = document.createElement("a");
        let s;

        function r(i) {
            let o = i;
            return t && (n.setAttribute("href", o), o = n.href), n.setAttribute("href", o), {
                href: n.href,
                protocol: n.protocol ? n.protocol.replace(/:$/, "") : "",
                host: n.host,
                search: n.search ? n.search.replace(/^\?/, "") : "",
                hash: n.hash ? n.hash.replace(/^#/, "") : "",
                hostname: n.hostname,
                port: n.port,
                pathname: n.pathname.charAt(0) === "/" ? n.pathname : "/" + n.pathname
            }
        }
        return s = r(window.location.href),
            function(o) {
                const a = f.isString(o) ? r(o) : o;
                return a.protocol === s.protocol && a.host === s.host
            }
    }() : function() {
        return function() {
            return !0
        }
    }(),
    zo = H.hasStandardBrowserEnv ? {
        write(e, t, n, s, r, i) {
            const o = [e + "=" + encodeURIComponent(t)];
            f.isNumber(n) && o.push("expires=" + new Date(n).toGMTString()), f.isString(s) && o.push("path=" + s), f.isString(r) && o.push("domain=" + r), i === !0 && o.push("secure"), document.cookie = o.join("; ")
        },
        read(e) {
            const t = document.cookie.match(new RegExp("(^|;\\s*)(" + e + ")=([^;]*)"));
            return t ? decodeURIComponent(t[3]) : null
        },
        remove(e) {
            this.write(e, "", Date.now() - 864e5)
        }
    } : {
        write() {},
        read() {
            return null
        },
        remove() {}
    };

function Go(e) {
    return /^([a-z][a-z\d+\-.]*:)?\/\//i.test(e)
}

function Xo(e, t) {
    return t ? e.replace(/\/?\/$/, "") + "/" + t.replace(/^\/+/, "") : e
}

function Tr(e, t) {
    return e && !Go(t) ? Xo(e, t) : t
}
const Es = e => e instanceof k ? {
    ...e
} : e;

function wt(e, t) {
    t = t || {};
    const n = {};

    function s(u, c, h) {
        return f.isPlainObject(u) && f.isPlainObject(c) ? f.merge.call({
            caseless: h
        }, u, c) : f.isPlainObject(c) ? f.merge({}, c) : f.isArray(c) ? c.slice() : c
    }

    function r(u, c, h) {
        if (f.isUndefined(c)) {
            if (!f.isUndefined(u)) return s(void 0, u, h)
        } else return s(u, c, h)
    }

    function i(u, c) {
        if (!f.isUndefined(c)) return s(void 0, c)
    }

    function o(u, c) {
        if (f.isUndefined(c)) {
            if (!f.isUndefined(u)) return s(void 0, u)
        } else return s(void 0, c)
    }

    function a(u, c, h) {
        if (h in t) return s(u, c);
        if (h in e) return s(void 0, u)
    }
    const l = {
        url: i,
        method: i,
        data: i,
        baseURL: o,
        transformRequest: o,
        transformResponse: o,
        paramsSerializer: o,
        timeout: o,
        timeoutMessage: o,
        withCredentials: o,
        withXSRFToken: o,
        adapter: o,
        responseType: o,
        xsrfCookieName: o,
        xsrfHeaderName: o,
        onUploadProgress: o,
        onDownloadProgress: o,
        decompress: o,
        maxContentLength: o,
        maxBodyLength: o,
        beforeRedirect: o,
        transport: o,
        httpAgent: o,
        httpsAgent: o,
        cancelToken: o,
        socketPath: o,
        responseEncoding: o,
        validateStatus: a,
        headers: (u, c) => r(Es(u), Es(c), !0)
    };
    return f.forEach(Object.keys(Object.assign({}, e, t)), function(c) {
        const h = l[c] || r,
            E = h(e[c], t[c], c);
        f.isUndefined(E) && h !== a || (n[c] = E)
    }), n
}
const wr = e => {
        const t = wt({}, e);
        let {
            data: n,
            withXSRFToken: s,
            xsrfHeaderName: r,
            xsrfCookieName: i,
            headers: o,
            auth: a
        } = t;
        t.headers = o = k.from(o), t.url = Er(Tr(t.baseURL, t.url), e.params, e.paramsSerializer), a && o.set("Authorization", "Basic " + btoa((a.username || "") + ":" + (a.password ? unescape(encodeURIComponent(a.password)) : "")));
        let l;
        if (f.isFormData(n)) {
            if (H.hasStandardBrowserEnv || H.hasStandardBrowserWebWorkerEnv) o.setContentType(void 0);
            else if ((l = o.getContentType()) !== !1) {
                const [u, ...c] = l ? l.split(";").map(h => h.trim()).filter(Boolean) : [];
                o.setContentType([u || "multipart/form-data", ...c].join("; "))
            }
        }
        if (H.hasStandardBrowserEnv && (s && f.isFunction(s) && (s = s(t)), s || s !== !1 && Yo(t.url))) {
            const u = r && i && zo.read(i);
            u && o.set(r, u)
        }
        return t
    },
    Jo = typeof XMLHttpRequest < "u",
    Qo = Jo && function(e) {
        return new Promise(function(n, s) {
            const r = wr(e);
            let i = r.data;
            const o = k.from(r.headers).normalize();
            let {
                responseType: a,
                onUploadProgress: l,
                onDownloadProgress: u
            } = r, c, h, E, g, m;

            function _() {
                g && g(), m && m(), r.cancelToken && r.cancelToken.unsubscribe(c), r.signal && r.signal.removeEventListener("abort", c)
            }
            let p = new XMLHttpRequest;
            p.open(r.method.toUpperCase(), r.url, !0), p.timeout = r.timeout;

            function T() {
                if (!p) return;
                const y = k.from("getAllResponseHeaders" in p && p.getAllResponseHeaders()),
                    w = {
                        data: !a || a === "text" || a === "json" ? p.responseText : p.response,
                        status: p.status,
                        statusText: p.statusText,
                        headers: y,
                        config: e,
                        request: p
                    };
                Ar(function(S) {
                    n(S), _()
                }, function(S) {
                    s(S), _()
                }, w), p = null
            }
            "onloadend" in p ? p.onloadend = T : p.onreadystatechange = function() {
                !p || p.readyState !== 4 || p.status === 0 && !(p.responseURL && p.responseURL.indexOf("file:") === 0) || setTimeout(T)
            }, p.onabort = function() {
                p && (s(new A("Request aborted", A.ECONNABORTED, e, p)), p = null)
            }, p.onerror = function() {
                s(new A("Network Error", A.ERR_NETWORK, e, p)), p = null
            }, p.ontimeout = function() {
                let b = r.timeout ? "timeout of " + r.timeout + "ms exceeded" : "timeout exceeded";
                const w = r.transitional || br;
                r.timeoutErrorMessage && (b = r.timeoutErrorMessage), s(new A(b, w.clarifyTimeoutError ? A.ETIMEDOUT : A.ECONNABORTED, e, p)), p = null
            }, i === void 0 && o.setContentType(null), "setRequestHeader" in p && f.forEach(o.toJSON(), function(b, w) {
                p.setRequestHeader(w, b)
            }), f.isUndefined(r.withCredentials) || (p.withCredentials = !!r.withCredentials), a && a !== "json" && (p.responseType = r.responseType), u && ([E, m] = Ne(u, !0), p.addEventListener("progress", E)), l && p.upload && ([h, g] = Ne(l), p.upload.addEventListener("progress", h), p.upload.addEventListener("loadend", g)), (r.cancelToken || r.signal) && (c = y => {
                p && (s(!y || y.type ? new Wt(null, e, p) : y), p.abort(), p = null)
            }, r.cancelToken && r.cancelToken.subscribe(c), r.signal && (r.signal.aborted ? c() : r.signal.addEventListener("abort", c)));
            const O = Wo(r.url);
            if (O && H.protocols.indexOf(O) === -1) {
                s(new A("Unsupported protocol " + O + ":", A.ERR_BAD_REQUEST, e));
                return
            }
            p.send(i || null)
        })
    },
    Zo = (e, t) => {
        let n = new AbortController,
            s;
        const r = function(l) {
            if (!s) {
                s = !0, o();
                const u = l instanceof Error ? l : this.reason;
                n.abort(u instanceof A ? u : new Wt(u instanceof Error ? u.message : u))
            }
        };
        let i = t && setTimeout(() => {
            r(new A(`timeout ${t} of ms exceeded`, A.ETIMEDOUT))
        }, t);
        const o = () => {
            e && (i && clearTimeout(i), i = null, e.forEach(l => {
                l && (l.removeEventListener ? l.removeEventListener("abort", r) : l.unsubscribe(r))
            }), e = null)
        };
        e.forEach(l => l && l.addEventListener && l.addEventListener("abort", r));
        const {
            signal: a
        } = n;
        return a.unsubscribe = o, [a, () => {
            i && clearTimeout(i), i = null
        }]
    },
    ta = function*(e, t) {
        let n = e.byteLength;
        if (!t || n < t) {
            yield e;
            return
        }
        let s = 0,
            r;
        for (; s < n;) r = s + t, yield e.slice(s, r), s = r
    },
    ea = async function*(e, t, n) {
        for await (const s of e) yield* ta(ArrayBuffer.isView(s) ? s : await n(String(s)), t)
    }, bs = (e, t, n, s, r) => {
        const i = ea(e, t, r);
        let o = 0,
            a, l = u => {
                a || (a = !0, s && s(u))
            };
        return new ReadableStream({
            async pull(u) {
                try {
                    const {
                        done: c,
                        value: h
                    } = await i.next();
                    if (c) {
                        l(), u.close();
                        return
                    }
                    let E = h.byteLength;
                    if (n) {
                        let g = o += E;
                        n(g)
                    }
                    u.enqueue(new Uint8Array(h))
                } catch (c) {
                    throw l(c), c
                }
            },
            cancel(u) {
                return l(u), i.return()
            }
        }, {
            highWaterMark: 2
        })
    }, Ve = typeof fetch == "function" && typeof Request == "function" && typeof Response == "function", Or = Ve && typeof ReadableStream == "function", vn = Ve && (typeof TextEncoder == "function" ? (e => t => e.encode(t))(new TextEncoder) : async e => new Uint8Array(await new Response(e).arrayBuffer())), Sr = (e, ...t) => {
        try {
            return !!e(...t)
        } catch {
            return !1
        }
    }, na = Or && Sr(() => {
        let e = !1;
        const t = new Request(H.origin, {
            body: new ReadableStream,
            method: "POST",
            get duplex() {
                return e = !0, "half"
            }
        }).headers.has("Content-Type");
        return e && !t
    }), vs = 64 * 1024, yn = Or && Sr(() => f.isReadableStream(new Response("").body)), De = {
        stream: yn && (e => e.body)
    };
Ve && (e => {
    ["text", "arrayBuffer", "blob", "formData", "stream"].forEach(t => {
        !De[t] && (De[t] = f.isFunction(e[t]) ? n => n[t]() : (n, s) => {
            throw new A(`Response type '${t}' is not supported`, A.ERR_NOT_SUPPORT, s)
        })
    })
})(new Response);
const sa = async e => {
    if (e == null) return 0;
    if (f.isBlob(e)) return e.size;
    if (f.isSpecCompliantForm(e)) return (await new Request(e).arrayBuffer()).byteLength;
    if (f.isArrayBufferView(e) || f.isArrayBuffer(e)) return e.byteLength;
    if (f.isURLSearchParams(e) && (e = e + ""), f.isString(e)) return (await vn(e)).byteLength
}, ra = async (e, t) => {
    const n = f.toFiniteNumber(e.getContentLength());
    return n ?? sa(t)
}, ia = Ve && (async e => {
    let {
        url: t,
        method: n,
        data: s,
        signal: r,
        cancelToken: i,
        timeout: o,
        onDownloadProgress: a,
        onUploadProgress: l,
        responseType: u,
        headers: c,
        withCredentials: h = "same-origin",
        fetchOptions: E
    } = wr(e);
    u = u ? (u + "").toLowerCase() : "text";
    let [g, m] = r || i || o ? Zo([r, i], o) : [], _, p;
    const T = () => {
        !_ && setTimeout(() => {
            g && g.unsubscribe()
        }), _ = !0
    };
    let O;
    try {
        if (l && na && n !== "get" && n !== "head" && (O = await ra(c, s)) !== 0) {
            let S = new Request(t, {
                    method: "POST",
                    body: s,
                    duplex: "half"
                }),
                N;
            if (f.isFormData(s) && (N = S.headers.get("content-type")) && c.setContentType(N), S.body) {
                const [L, D] = _s(O, Ne(gs(l)));
                s = bs(S.body, vs, L, D, vn)
            }
        }
        f.isString(h) || (h = h ? "include" : "omit");
        const y = "credentials" in Request.prototype;
        p = new Request(t, {
            ...E,
            signal: g,
            method: n.toUpperCase(),
            headers: c.normalize().toJSON(),
            body: s,
            duplex: "half",
            credentials: y ? h : void 0
        });
        let b = await fetch(p);
        const w = yn && (u === "stream" || u === "response");
        if (yn && (a || w)) {
            const S = {};
            ["status", "statusText", "headers"].forEach($ => {
                S[$] = b[$]
            });
            const N = f.toFiniteNumber(b.headers.get("content-length")),
                [L, D] = a && _s(N, Ne(gs(a), !0)) || [];
            b = new Response(bs(b.body, vs, L, () => {
                D && D(), w && T()
            }, vn), S)
        }
        u = u || "text";
        let C = await De[f.findKey(De, u) || "text"](b, e);
        return !w && T(), m && m(), await new Promise((S, N) => {
            Ar(S, N, {
                data: C,
                headers: k.from(b.headers),
                status: b.status,
                statusText: b.statusText,
                config: e,
                request: p
            })
        })
    } catch (y) {
        throw T(), y && y.name === "TypeError" && /fetch/i.test(y.message) ? Object.assign(new A("Network Error", A.ERR_NETWORK, e, p), {
            cause: y.cause || y
        }) : A.from(y, y && y.code, e, p)
    }
}), An = {
    http: Ao,
    xhr: Qo,
    fetch: ia
};
f.forEach(An, (e, t) => {
    if (e) {
        try {
            Object.defineProperty(e, "name", {
                value: t
            })
        } catch {}
        Object.defineProperty(e, "adapterName", {
            value: t
        })
    }
});
const ys = e => `- ${e}`,
    oa = e => f.isFunction(e) || e === null || e === !1,
    Cr = {
        getAdapter: e => {
            e = f.isArray(e) ? e : [e];
            const {
                length: t
            } = e;
            let n, s;
            const r = {};
            for (let i = 0; i < t; i++) {
                n = e[i];
                let o;
                if (s = n, !oa(n) && (s = An[(o = String(n)).toLowerCase()], s === void 0)) throw new A(`Unknown adapter '${o}'`);
                if (s) break;
                r[o || "#" + i] = s
            }
            if (!s) {
                const i = Object.entries(r).map(([a, l]) => `adapter ${a} ` + (l === !1 ? "is not supported by the environment" : "is not available in the build"));
                let o = t ? i.length > 1 ? `since :
` + i.map(ys).join(`
`) : " " + ys(i[0]) : "as no adapter specified";
                throw new A("There is no suitable adapter to dispatch the request " + o, "ERR_NOT_SUPPORT")
            }
            return s
        },
        adapters: An
    };

function tn(e) {
    if (e.cancelToken && e.cancelToken.throwIfRequested(), e.signal && e.signal.aborted) throw new Wt(null, e)
}

function As(e) {
    return tn(e), e.headers = k.from(e.headers), e.data = Ze.call(e, e.transformRequest), ["post", "put", "patch"].indexOf(e.method) !== -1 && e.headers.setContentType("application/x-www-form-urlencoded", !1), Cr.getAdapter(e.adapter || ie.adapter)(e).then(function(s) {
        return tn(e), s.data = Ze.call(e, e.transformResponse, s), s.headers = k.from(s.headers), s
    }, function(s) {
        return yr(s) || (tn(e), s && s.response && (s.response.data = Ze.call(e, e.transformResponse, s.response), s.response.headers = k.from(s.response.headers))), Promise.reject(s)
    })
}
const Nr = "1.7.5",
    Pn = {};
["object", "boolean", "number", "function", "string", "symbol"].forEach((e, t) => {
    Pn[e] = function(s) {
        return typeof s === e || "a" + (t < 1 ? "n " : " ") + e
    }
});
const Ts = {};
Pn.transitional = function(t, n, s) {
    function r(i, o) {
        return "[Axios v" + Nr + "] Transitional option '" + i + "'" + o + (s ? ". " + s : "")
    }
    return (i, o, a) => {
        if (t === !1) throw new A(r(o, " has been removed" + (n ? " in " + n : "")), A.ERR_DEPRECATED);
        return n && !Ts[o] && (Ts[o] = !0, console.warn(r(o, " has been deprecated since v" + n + " and will be removed in the near future"))), t ? t(i, o, a) : !0
    }
};

function aa(e, t, n) {
    if (typeof e != "object") throw new A("options must be an object", A.ERR_BAD_OPTION_VALUE);
    const s = Object.keys(e);
    let r = s.length;
    for (; r-- > 0;) {
        const i = s[r],
            o = t[i];
        if (o) {
            const a = e[i],
                l = a === void 0 || o(a, i, e);
            if (l !== !0) throw new A("option " + i + " must be " + l, A.ERR_BAD_OPTION_VALUE);
            continue
        }
        if (n !== !0) throw new A("Unknown option " + i, A.ERR_BAD_OPTION)
    }
}
const Tn = {
        assertOptions: aa,
        validators: Pn
    },
    ot = Tn.validators;
class At {
    constructor(t) {
        this.defaults = t, this.interceptors = {
            request: new ps,
            response: new ps
        }
    }
    async request(t, n) {
        try {
            return await this._request(t, n)
        } catch (s) {
            if (s instanceof Error) {
                let r;
                Error.captureStackTrace ? Error.captureStackTrace(r = {}) : r = new Error;
                const i = r.stack ? r.stack.replace(/^.+\n/, "") : "";
                try {
                    s.stack ? i && !String(s.stack).endsWith(i.replace(/^.+\n.+\n/, "")) && (s.stack += `
` + i) : s.stack = i
                } catch {}
            }
            throw s
        }
    }
    _request(t, n) {
        typeof t == "string" ? (n = n || {}, n.url = t) : n = t || {}, n = wt(this.defaults, n);
        const {
            transitional: s,
            paramsSerializer: r,
            headers: i
        } = n;
        s !== void 0 && Tn.assertOptions(s, {
            silentJSONParsing: ot.transitional(ot.boolean),
            forcedJSONParsing: ot.transitional(ot.boolean),
            clarifyTimeoutError: ot.transitional(ot.boolean)
        }, !1), r != null && (f.isFunction(r) ? n.paramsSerializer = {
            serialize: r
        } : Tn.assertOptions(r, {
            encode: ot.function,
            serialize: ot.function
        }, !0)), n.method = (n.method || this.defaults.method || "get").toLowerCase();
        let o = i && f.merge(i.common, i[n.method]);
        i && f.forEach(["delete", "get", "head", "post", "put", "patch", "common"], m => {
            delete i[m]
        }), n.headers = k.concat(o, i);
        const a = [];
        let l = !0;
        this.interceptors.request.forEach(function(_) {
            typeof _.runWhen == "function" && _.runWhen(n) === !1 || (l = l && _.synchronous, a.unshift(_.fulfilled, _.rejected))
        });
        const u = [];
        this.interceptors.response.forEach(function(_) {
            u.push(_.fulfilled, _.rejected)
        });
        let c, h = 0,
            E;
        if (!l) {
            const m = [As.bind(this), void 0];
            for (m.unshift.apply(m, a), m.push.apply(m, u), E = m.length, c = Promise.resolve(n); h < E;) c = c.then(m[h++], m[h++]);
            return c
        }
        E = a.length;
        let g = n;
        for (h = 0; h < E;) {
            const m = a[h++],
                _ = a[h++];
            try {
                g = m(g)
            } catch (p) {
                _.call(this, p);
                break
            }
        }
        try {
            c = As.call(this, g)
        } catch (m) {
            return Promise.reject(m)
        }
        for (h = 0, E = u.length; h < E;) c = c.then(u[h++], u[h++]);
        return c
    }
    getUri(t) {
        t = wt(this.defaults, t);
        const n = Tr(t.baseURL, t.url);
        return Er(n, t.params, t.paramsSerializer)
    }
}
f.forEach(["delete", "get", "head", "options"], function(t) {
    At.prototype[t] = function(n, s) {
        return this.request(wt(s || {}, {
            method: t,
            url: n,
            data: (s || {}).data
        }))
    }
});
f.forEach(["post", "put", "patch"], function(t) {
    function n(s) {
        return function(i, o, a) {
            return this.request(wt(a || {}, {
                method: t,
                headers: s ? {
                    "Content-Type": "multipart/form-data"
                } : {},
                url: i,
                data: o
            }))
        }
    }
    At.prototype[t] = n(), At.prototype[t + "Form"] = n(!0)
});
class Mn {
    constructor(t) {
        if (typeof t != "function") throw new TypeError("executor must be a function.");
        let n;
        this.promise = new Promise(function(i) {
            n = i
        });
        const s = this;
        this.promise.then(r => {
            if (!s._listeners) return;
            let i = s._listeners.length;
            for (; i-- > 0;) s._listeners[i](r);
            s._listeners = null
        }), this.promise.then = r => {
            let i;
            const o = new Promise(a => {
                s.subscribe(a), i = a
            }).then(r);
            return o.cancel = function() {
                s.unsubscribe(i)
            }, o
        }, t(function(i, o, a) {
            s.reason || (s.reason = new Wt(i, o, a), n(s.reason))
        })
    }
    throwIfRequested() {
        if (this.reason) throw this.reason
    }
    subscribe(t) {
        if (this.reason) {
            t(this.reason);
            return
        }
        this._listeners ? this._listeners.push(t) : this._listeners = [t]
    }
    unsubscribe(t) {
        if (!this._listeners) return;
        const n = this._listeners.indexOf(t);
        n !== -1 && this._listeners.splice(n, 1)
    }
    static source() {
        let t;
        return {
            token: new Mn(function(r) {
                t = r
            }),
            cancel: t
        }
    }
}

function ca(e) {
    return function(n) {
        return e.apply(null, n)
    }
}

function la(e) {
    return f.isObject(e) && e.isAxiosError === !0
}
const wn = {
    Continue: 100,
    SwitchingProtocols: 101,
    Processing: 102,
    EarlyHints: 103,
    Ok: 200,
    Created: 201,
    Accepted: 202,
    NonAuthoritativeInformation: 203,
    NoContent: 204,
    ResetContent: 205,
    PartialContent: 206,
    MultiStatus: 207,
    AlreadyReported: 208,
    ImUsed: 226,
    MultipleChoices: 300,
    MovedPermanently: 301,
    Found: 302,
    SeeOther: 303,
    NotModified: 304,
    UseProxy: 305,
    Unused: 306,
    TemporaryRedirect: 307,
    PermanentRedirect: 308,
    BadRequest: 400,
    Unauthorized: 401,
    PaymentRequired: 402,
    Forbidden: 403,
    NotFound: 404,
    MethodNotAllowed: 405,
    NotAcceptable: 406,
    ProxyAuthenticationRequired: 407,
    RequestTimeout: 408,
    Conflict: 409,
    Gone: 410,
    LengthRequired: 411,
    PreconditionFailed: 412,
    PayloadTooLarge: 413,
    UriTooLong: 414,
    UnsupportedMediaType: 415,
    RangeNotSatisfiable: 416,
    ExpectationFailed: 417,
    ImATeapot: 418,
    MisdirectedRequest: 421,
    UnprocessableEntity: 422,
    Locked: 423,
    FailedDependency: 424,
    TooEarly: 425,
    UpgradeRequired: 426,
    PreconditionRequired: 428,
    TooManyRequests: 429,
    RequestHeaderFieldsTooLarge: 431,
    UnavailableForLegalReasons: 451,
    InternalServerError: 500,
    NotImplemented: 501,
    BadGateway: 502,
    ServiceUnavailable: 503,
    GatewayTimeout: 504,
    HttpVersionNotSupported: 505,
    VariantAlsoNegotiates: 506,
    InsufficientStorage: 507,
    LoopDetected: 508,
    NotExtended: 510,
    NetworkAuthenticationRequired: 511
};
Object.entries(wn).forEach(([e, t]) => {
    wn[t] = e
});

function Dr(e) {
    const t = new At(e),
        n = or(At.prototype.request, t);
    return f.extend(n, At.prototype, t, {
        allOwnKeys: !0
    }), f.extend(n, t, null, {
        allOwnKeys: !0
    }), n.create = function(r) {
        return Dr(wt(e, r))
    }, n
}
const R = Dr(ie);
R.Axios = At;
R.CanceledError = Wt;
R.CancelToken = Mn;
R.isCancel = yr;
R.VERSION = Nr;
R.toFormData = ke;
R.AxiosError = A;
R.Cancel = R.CanceledError;
R.all = function(t) {
    return Promise.all(t)
};
R.spread = ca;
R.isAxiosError = la;
R.mergeConfig = wt;
R.AxiosHeaders = k;
R.formToJSON = e => vr(f.isHTMLForm(e) ? new FormData(e) : e);
R.getAdapter = Cr.getAdapter;
R.HttpStatusCode = wn;
R.default = R;
window.axios = R;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
var x = "top",
    B = "bottom",
    j = "right",
    P = "left",
    Fe = "auto",
    Kt = [x, B, j, P],
    Ot = "start",
    Mt = "end",
    Lr = "clippingParents",
    kn = "viewport",
    $t = "popper",
    Rr = "reference",
    On = Kt.reduce(function(e, t) {
        return e.concat([t + "-" + Ot, t + "-" + Mt])
    }, []),
    Vn = [].concat(Kt, [Fe]).reduce(function(e, t) {
        return e.concat([t, t + "-" + Ot, t + "-" + Mt])
    }, []),
    $r = "beforeRead",
    Ir = "read",
    xr = "afterRead",
    Pr = "beforeMain",
    Mr = "main",
    kr = "afterMain",
    Vr = "beforeWrite",
    Fr = "write",
    Hr = "afterWrite",
    Br = [$r, Ir, xr, Pr, Mr, kr, Vr, Fr, Hr];

function tt(e) {
    return e ? (e.nodeName || "").toLowerCase() : null
}

function U(e) {
    if (e == null) return window;
    if (e.toString() !== "[object Window]") {
        var t = e.ownerDocument;
        return t && t.defaultView || window
    }
    return e
}

function St(e) {
    var t = U(e).Element;
    return e instanceof t || e instanceof Element
}

function W(e) {
    var t = U(e).HTMLElement;
    return e instanceof t || e instanceof HTMLElement
}

function Fn(e) {
    if (typeof ShadowRoot > "u") return !1;
    var t = U(e).ShadowRoot;
    return e instanceof t || e instanceof ShadowRoot
}

function ua(e) {
    var t = e.state;
    Object.keys(t.elements).forEach(function(n) {
        var s = t.styles[n] || {},
            r = t.attributes[n] || {},
            i = t.elements[n];
        !W(i) || !tt(i) || (Object.assign(i.style, s), Object.keys(r).forEach(function(o) {
            var a = r[o];
            a === !1 ? i.removeAttribute(o) : i.setAttribute(o, a === !0 ? "" : a)
        }))
    })
}

function fa(e) {
    var t = e.state,
        n = {
            popper: {
                position: t.options.strategy,
                left: "0",
                top: "0",
                margin: "0"
            },
            arrow: {
                position: "absolute"
            },
            reference: {}
        };
    return Object.assign(t.elements.popper.style, n.popper), t.styles = n, t.elements.arrow && Object.assign(t.elements.arrow.style, n.arrow),
        function() {
            Object.keys(t.elements).forEach(function(s) {
                var r = t.elements[s],
                    i = t.attributes[s] || {},
                    o = Object.keys(t.styles.hasOwnProperty(s) ? t.styles[s] : n[s]),
                    a = o.reduce(function(l, u) {
                        return l[u] = "", l
                    }, {});
                !W(r) || !tt(r) || (Object.assign(r.style, a), Object.keys(i).forEach(function(l) {
                    r.removeAttribute(l)
                }))
            })
        }
}
const Hn = {
    name: "applyStyles",
    enabled: !0,
    phase: "write",
    fn: ua,
    effect: fa,
    requires: ["computeStyles"]
};

function Q(e) {
    return e.split("-")[0]
}
var Tt = Math.max,
    Le = Math.min,
    kt = Math.round;

function Sn() {
    var e = navigator.userAgentData;
    return e != null && e.brands && Array.isArray(e.brands) ? e.brands.map(function(t) {
        return t.brand + "/" + t.version
    }).join(" ") : navigator.userAgent
}

function jr() {
    return !/^((?!chrome|android).)*safari/i.test(Sn())
}

function Vt(e, t, n) {
    t === void 0 && (t = !1), n === void 0 && (n = !1);
    var s = e.getBoundingClientRect(),
        r = 1,
        i = 1;
    t && W(e) && (r = e.offsetWidth > 0 && kt(s.width) / e.offsetWidth || 1, i = e.offsetHeight > 0 && kt(s.height) / e.offsetHeight || 1);
    var o = St(e) ? U(e) : window,
        a = o.visualViewport,
        l = !jr() && n,
        u = (s.left + (l && a ? a.offsetLeft : 0)) / r,
        c = (s.top + (l && a ? a.offsetTop : 0)) / i,
        h = s.width / r,
        E = s.height / i;
    return {
        width: h,
        height: E,
        top: c,
        right: u + h,
        bottom: c + E,
        left: u,
        x: u,
        y: c
    }
}

function Bn(e) {
    var t = Vt(e),
        n = e.offsetWidth,
        s = e.offsetHeight;
    return Math.abs(t.width - n) <= 1 && (n = t.width), Math.abs(t.height - s) <= 1 && (s = t.height), {
        x: e.offsetLeft,
        y: e.offsetTop,
        width: n,
        height: s
    }
}

function Ur(e, t) {
    var n = t.getRootNode && t.getRootNode();
    if (e.contains(t)) return !0;
    if (n && Fn(n)) {
        var s = t;
        do {
            if (s && e.isSameNode(s)) return !0;
            s = s.parentNode || s.host
        } while (s)
    }
    return !1
}

function st(e) {
    return U(e).getComputedStyle(e)
}

function da(e) {
    return ["table", "td", "th"].indexOf(tt(e)) >= 0
}

function ft(e) {
    return ((St(e) ? e.ownerDocument : e.document) || window.document).documentElement
}

function He(e) {
    return tt(e) === "html" ? e : e.assignedSlot || e.parentNode || (Fn(e) ? e.host : null) || ft(e)
}

function ws(e) {
    return !W(e) || st(e).position === "fixed" ? null : e.offsetParent
}

function ha(e) {
    var t = /firefox/i.test(Sn()),
        n = /Trident/i.test(Sn());
    if (n && W(e)) {
        var s = st(e);
        if (s.position === "fixed") return null
    }
    var r = He(e);
    for (Fn(r) && (r = r.host); W(r) && ["html", "body"].indexOf(tt(r)) < 0;) {
        var i = st(r);
        if (i.transform !== "none" || i.perspective !== "none" || i.contain === "paint" || ["transform", "perspective"].indexOf(i.willChange) !== -1 || t && i.willChange === "filter" || t && i.filter && i.filter !== "none") return r;
        r = r.parentNode
    }
    return null
}

function oe(e) {
    for (var t = U(e), n = ws(e); n && da(n) && st(n).position === "static";) n = ws(n);
    return n && (tt(n) === "html" || tt(n) === "body" && st(n).position === "static") ? t : n || ha(e) || t
}

function jn(e) {
    return ["top", "bottom"].indexOf(e) >= 0 ? "x" : "y"
}

function te(e, t, n) {
    return Tt(e, Le(t, n))
}

function pa(e, t, n) {
    var s = te(e, t, n);
    return s > n ? n : s
}

function Wr() {
    return {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }
}

function Kr(e) {
    return Object.assign({}, Wr(), e)
}

function qr(e, t) {
    return t.reduce(function(n, s) {
        return n[s] = e, n
    }, {})
}
var ma = function(t, n) {
    return t = typeof t == "function" ? t(Object.assign({}, n.rects, {
        placement: n.placement
    })) : t, Kr(typeof t != "number" ? t : qr(t, Kt))
};

function _a(e) {
    var t, n = e.state,
        s = e.name,
        r = e.options,
        i = n.elements.arrow,
        o = n.modifiersData.popperOffsets,
        a = Q(n.placement),
        l = jn(a),
        u = [P, j].indexOf(a) >= 0,
        c = u ? "height" : "width";
    if (!(!i || !o)) {
        var h = ma(r.padding, n),
            E = Bn(i),
            g = l === "y" ? x : P,
            m = l === "y" ? B : j,
            _ = n.rects.reference[c] + n.rects.reference[l] - o[l] - n.rects.popper[c],
            p = o[l] - n.rects.reference[l],
            T = oe(i),
            O = T ? l === "y" ? T.clientHeight || 0 : T.clientWidth || 0 : 0,
            y = _ / 2 - p / 2,
            b = h[g],
            w = O - E[c] - h[m],
            C = O / 2 - E[c] / 2 + y,
            S = te(b, C, w),
            N = l;
        n.modifiersData[s] = (t = {}, t[N] = S, t.centerOffset = S - C, t)
    }
}

function ga(e) {
    var t = e.state,
        n = e.options,
        s = n.element,
        r = s === void 0 ? "[data-popper-arrow]" : s;
    r != null && (typeof r == "string" && (r = t.elements.popper.querySelector(r), !r) || Ur(t.elements.popper, r) && (t.elements.arrow = r))
}
const Yr = {
    name: "arrow",
    enabled: !0,
    phase: "main",
    fn: _a,
    effect: ga,
    requires: ["popperOffsets"],
    requiresIfExists: ["preventOverflow"]
};

function Ft(e) {
    return e.split("-")[1]
}
var Ea = {
    top: "auto",
    right: "auto",
    bottom: "auto",
    left: "auto"
};

function ba(e, t) {
    var n = e.x,
        s = e.y,
        r = t.devicePixelRatio || 1;
    return {
        x: kt(n * r) / r || 0,
        y: kt(s * r) / r || 0
    }
}

function Os(e) {
    var t, n = e.popper,
        s = e.popperRect,
        r = e.placement,
        i = e.variation,
        o = e.offsets,
        a = e.position,
        l = e.gpuAcceleration,
        u = e.adaptive,
        c = e.roundOffsets,
        h = e.isFixed,
        E = o.x,
        g = E === void 0 ? 0 : E,
        m = o.y,
        _ = m === void 0 ? 0 : m,
        p = typeof c == "function" ? c({
            x: g,
            y: _
        }) : {
            x: g,
            y: _
        };
    g = p.x, _ = p.y;
    var T = o.hasOwnProperty("x"),
        O = o.hasOwnProperty("y"),
        y = P,
        b = x,
        w = window;
    if (u) {
        var C = oe(n),
            S = "clientHeight",
            N = "clientWidth";
        if (C === U(n) && (C = ft(n), st(C).position !== "static" && a === "absolute" && (S = "scrollHeight", N = "scrollWidth")), C = C, r === x || (r === P || r === j) && i === Mt) {
            b = B;
            var L = h && C === w && w.visualViewport ? w.visualViewport.height : C[S];
            _ -= L - s.height, _ *= l ? 1 : -1
        }
        if (r === P || (r === x || r === B) && i === Mt) {
            y = j;
            var D = h && C === w && w.visualViewport ? w.visualViewport.width : C[N];
            g -= D - s.width, g *= l ? 1 : -1
        }
    }
    var $ = Object.assign({
            position: a
        }, u && Ea),
        z = c === !0 ? ba({
            x: g,
            y: _
        }, U(n)) : {
            x: g,
            y: _
        };
    if (g = z.x, _ = z.y, l) {
        var I;
        return Object.assign({}, $, (I = {}, I[b] = O ? "0" : "", I[y] = T ? "0" : "", I.transform = (w.devicePixelRatio || 1) <= 1 ? "translate(" + g + "px, " + _ + "px)" : "translate3d(" + g + "px, " + _ + "px, 0)", I))
    }
    return Object.assign({}, $, (t = {}, t[b] = O ? _ + "px" : "", t[y] = T ? g + "px" : "", t.transform = "", t))
}

function va(e) {
    var t = e.state,
        n = e.options,
        s = n.gpuAcceleration,
        r = s === void 0 ? !0 : s,
        i = n.adaptive,
        o = i === void 0 ? !0 : i,
        a = n.roundOffsets,
        l = a === void 0 ? !0 : a,
        u = {
            placement: Q(t.placement),
            variation: Ft(t.placement),
            popper: t.elements.popper,
            popperRect: t.rects.popper,
            gpuAcceleration: r,
            isFixed: t.options.strategy === "fixed"
        };
    t.modifiersData.popperOffsets != null && (t.styles.popper = Object.assign({}, t.styles.popper, Os(Object.assign({}, u, {
        offsets: t.modifiersData.popperOffsets,
        position: t.options.strategy,
        adaptive: o,
        roundOffsets: l
    })))), t.modifiersData.arrow != null && (t.styles.arrow = Object.assign({}, t.styles.arrow, Os(Object.assign({}, u, {
        offsets: t.modifiersData.arrow,
        position: "absolute",
        adaptive: !1,
        roundOffsets: l
    })))), t.attributes.popper = Object.assign({}, t.attributes.popper, {
        "data-popper-placement": t.placement
    })
}
const Un = {
    name: "computeStyles",
    enabled: !0,
    phase: "beforeWrite",
    fn: va,
    data: {}
};
var _e = {
    passive: !0
};

function ya(e) {
    var t = e.state,
        n = e.instance,
        s = e.options,
        r = s.scroll,
        i = r === void 0 ? !0 : r,
        o = s.resize,
        a = o === void 0 ? !0 : o,
        l = U(t.elements.popper),
        u = [].concat(t.scrollParents.reference, t.scrollParents.popper);
    return i && u.forEach(function(c) {
            c.addEventListener("scroll", n.update, _e)
        }), a && l.addEventListener("resize", n.update, _e),
        function() {
            i && u.forEach(function(c) {
                c.removeEventListener("scroll", n.update, _e)
            }), a && l.removeEventListener("resize", n.update, _e)
        }
}
const Wn = {
    name: "eventListeners",
    enabled: !0,
    phase: "write",
    fn: function() {},
    effect: ya,
    data: {}
};
var Aa = {
    left: "right",
    right: "left",
    bottom: "top",
    top: "bottom"
};

function Oe(e) {
    return e.replace(/left|right|bottom|top/g, function(t) {
        return Aa[t]
    })
}
var Ta = {
    start: "end",
    end: "start"
};

function Ss(e) {
    return e.replace(/start|end/g, function(t) {
        return Ta[t]
    })
}

function Kn(e) {
    var t = U(e),
        n = t.pageXOffset,
        s = t.pageYOffset;
    return {
        scrollLeft: n,
        scrollTop: s
    }
}

function qn(e) {
    return Vt(ft(e)).left + Kn(e).scrollLeft
}

function wa(e, t) {
    var n = U(e),
        s = ft(e),
        r = n.visualViewport,
        i = s.clientWidth,
        o = s.clientHeight,
        a = 0,
        l = 0;
    if (r) {
        i = r.width, o = r.height;
        var u = jr();
        (u || !u && t === "fixed") && (a = r.offsetLeft, l = r.offsetTop)
    }
    return {
        width: i,
        height: o,
        x: a + qn(e),
        y: l
    }
}

function Oa(e) {
    var t, n = ft(e),
        s = Kn(e),
        r = (t = e.ownerDocument) == null ? void 0 : t.body,
        i = Tt(n.scrollWidth, n.clientWidth, r ? r.scrollWidth : 0, r ? r.clientWidth : 0),
        o = Tt(n.scrollHeight, n.clientHeight, r ? r.scrollHeight : 0, r ? r.clientHeight : 0),
        a = -s.scrollLeft + qn(e),
        l = -s.scrollTop;
    return st(r || n).direction === "rtl" && (a += Tt(n.clientWidth, r ? r.clientWidth : 0) - i), {
        width: i,
        height: o,
        x: a,
        y: l
    }
}

function Yn(e) {
    var t = st(e),
        n = t.overflow,
        s = t.overflowX,
        r = t.overflowY;
    return /auto|scroll|overlay|hidden/.test(n + r + s)
}

function zr(e) {
    return ["html", "body", "#document"].indexOf(tt(e)) >= 0 ? e.ownerDocument.body : W(e) && Yn(e) ? e : zr(He(e))
}

function ee(e, t) {
    var n;
    t === void 0 && (t = []);
    var s = zr(e),
        r = s === ((n = e.ownerDocument) == null ? void 0 : n.body),
        i = U(s),
        o = r ? [i].concat(i.visualViewport || [], Yn(s) ? s : []) : s,
        a = t.concat(o);
    return r ? a : a.concat(ee(He(o)))
}

function Cn(e) {
    return Object.assign({}, e, {
        left: e.x,
        top: e.y,
        right: e.x + e.width,
        bottom: e.y + e.height
    })
}

function Sa(e, t) {
    var n = Vt(e, !1, t === "fixed");
    return n.top = n.top + e.clientTop, n.left = n.left + e.clientLeft, n.bottom = n.top + e.clientHeight, n.right = n.left + e.clientWidth, n.width = e.clientWidth, n.height = e.clientHeight, n.x = n.left, n.y = n.top, n
}

function Cs(e, t, n) {
    return t === kn ? Cn(wa(e, n)) : St(t) ? Sa(t, n) : Cn(Oa(ft(e)))
}

function Ca(e) {
    var t = ee(He(e)),
        n = ["absolute", "fixed"].indexOf(st(e).position) >= 0,
        s = n && W(e) ? oe(e) : e;
    return St(s) ? t.filter(function(r) {
        return St(r) && Ur(r, s) && tt(r) !== "body"
    }) : []
}

function Na(e, t, n, s) {
    var r = t === "clippingParents" ? Ca(e) : [].concat(t),
        i = [].concat(r, [n]),
        o = i[0],
        a = i.reduce(function(l, u) {
            var c = Cs(e, u, s);
            return l.top = Tt(c.top, l.top), l.right = Le(c.right, l.right), l.bottom = Le(c.bottom, l.bottom), l.left = Tt(c.left, l.left), l
        }, Cs(e, o, s));
    return a.width = a.right - a.left, a.height = a.bottom - a.top, a.x = a.left, a.y = a.top, a
}

function Gr(e) {
    var t = e.reference,
        n = e.element,
        s = e.placement,
        r = s ? Q(s) : null,
        i = s ? Ft(s) : null,
        o = t.x + t.width / 2 - n.width / 2,
        a = t.y + t.height / 2 - n.height / 2,
        l;
    switch (r) {
        case x:
            l = {
                x: o,
                y: t.y - n.height
            };
            break;
        case B:
            l = {
                x: o,
                y: t.y + t.height
            };
            break;
        case j:
            l = {
                x: t.x + t.width,
                y: a
            };
            break;
        case P:
            l = {
                x: t.x - n.width,
                y: a
            };
            break;
        default:
            l = {
                x: t.x,
                y: t.y
            }
    }
    var u = r ? jn(r) : null;
    if (u != null) {
        var c = u === "y" ? "height" : "width";
        switch (i) {
            case Ot:
                l[u] = l[u] - (t[c] / 2 - n[c] / 2);
                break;
            case Mt:
                l[u] = l[u] + (t[c] / 2 - n[c] / 2);
                break
        }
    }
    return l
}

function Ht(e, t) {
    t === void 0 && (t = {});
    var n = t,
        s = n.placement,
        r = s === void 0 ? e.placement : s,
        i = n.strategy,
        o = i === void 0 ? e.strategy : i,
        a = n.boundary,
        l = a === void 0 ? Lr : a,
        u = n.rootBoundary,
        c = u === void 0 ? kn : u,
        h = n.elementContext,
        E = h === void 0 ? $t : h,
        g = n.altBoundary,
        m = g === void 0 ? !1 : g,
        _ = n.padding,
        p = _ === void 0 ? 0 : _,
        T = Kr(typeof p != "number" ? p : qr(p, Kt)),
        O = E === $t ? Rr : $t,
        y = e.rects.popper,
        b = e.elements[m ? O : E],
        w = Na(St(b) ? b : b.contextElement || ft(e.elements.popper), l, c, o),
        C = Vt(e.elements.reference),
        S = Gr({
            reference: C,
            element: y,
            strategy: "absolute",
            placement: r
        }),
        N = Cn(Object.assign({}, y, S)),
        L = E === $t ? N : C,
        D = {
            top: w.top - L.top + T.top,
            bottom: L.bottom - w.bottom + T.bottom,
            left: w.left - L.left + T.left,
            right: L.right - w.right + T.right
        },
        $ = e.modifiersData.offset;
    if (E === $t && $) {
        var z = $[r];
        Object.keys(D).forEach(function(I) {
            var pt = [j, B].indexOf(I) >= 0 ? 1 : -1,
                mt = [x, B].indexOf(I) >= 0 ? "y" : "x";
            D[I] += z[mt] * pt
        })
    }
    return D
}

function Da(e, t) {
    t === void 0 && (t = {});
    var n = t,
        s = n.placement,
        r = n.boundary,
        i = n.rootBoundary,
        o = n.padding,
        a = n.flipVariations,
        l = n.allowedAutoPlacements,
        u = l === void 0 ? Vn : l,
        c = Ft(s),
        h = c ? a ? On : On.filter(function(m) {
            return Ft(m) === c
        }) : Kt,
        E = h.filter(function(m) {
            return u.indexOf(m) >= 0
        });
    E.length === 0 && (E = h);
    var g = E.reduce(function(m, _) {
        return m[_] = Ht(e, {
            placement: _,
            boundary: r,
            rootBoundary: i,
            padding: o
        })[Q(_)], m
    }, {});
    return Object.keys(g).sort(function(m, _) {
        return g[m] - g[_]
    })
}

function La(e) {
    if (Q(e) === Fe) return [];
    var t = Oe(e);
    return [Ss(e), t, Ss(t)]
}

function Ra(e) {
    var t = e.state,
        n = e.options,
        s = e.name;
    if (!t.modifiersData[s]._skip) {
        for (var r = n.mainAxis, i = r === void 0 ? !0 : r, o = n.altAxis, a = o === void 0 ? !0 : o, l = n.fallbackPlacements, u = n.padding, c = n.boundary, h = n.rootBoundary, E = n.altBoundary, g = n.flipVariations, m = g === void 0 ? !0 : g, _ = n.allowedAutoPlacements, p = t.options.placement, T = Q(p), O = T === p, y = l || (O || !m ? [Oe(p)] : La(p)), b = [p].concat(y).reduce(function(Dt, it) {
                return Dt.concat(Q(it) === Fe ? Da(t, {
                    placement: it,
                    boundary: c,
                    rootBoundary: h,
                    padding: u,
                    flipVariations: m,
                    allowedAutoPlacements: _
                }) : it)
            }, []), w = t.rects.reference, C = t.rects.popper, S = new Map, N = !0, L = b[0], D = 0; D < b.length; D++) {
            var $ = b[D],
                z = Q($),
                I = Ft($) === Ot,
                pt = [x, B].indexOf(z) >= 0,
                mt = pt ? "width" : "height",
                V = Ht(t, {
                    placement: $,
                    boundary: c,
                    rootBoundary: h,
                    altBoundary: E,
                    padding: u
                }),
                G = pt ? I ? j : P : I ? B : x;
            w[mt] > C[mt] && (G = Oe(G));
            var fe = Oe(G),
                _t = [];
            if (i && _t.push(V[z] <= 0), a && _t.push(V[G] <= 0, V[fe] <= 0), _t.every(function(Dt) {
                    return Dt
                })) {
                L = $, N = !1;
                break
            }
            S.set($, _t)
        }
        if (N)
            for (var de = m ? 3 : 1, Ye = function(it) {
                    var Xt = b.find(function(pe) {
                        var gt = S.get(pe);
                        if (gt) return gt.slice(0, it).every(function(ze) {
                            return ze
                        })
                    });
                    if (Xt) return L = Xt, "break"
                }, Gt = de; Gt > 0; Gt--) {
                var he = Ye(Gt);
                if (he === "break") break
            }
        t.placement !== L && (t.modifiersData[s]._skip = !0, t.placement = L, t.reset = !0)
    }
}
const Xr = {
    name: "flip",
    enabled: !0,
    phase: "main",
    fn: Ra,
    requiresIfExists: ["offset"],
    data: {
        _skip: !1
    }
};

function Ns(e, t, n) {
    return n === void 0 && (n = {
        x: 0,
        y: 0
    }), {
        top: e.top - t.height - n.y,
        right: e.right - t.width + n.x,
        bottom: e.bottom - t.height + n.y,
        left: e.left - t.width - n.x
    }
}

function Ds(e) {
    return [x, j, B, P].some(function(t) {
        return e[t] >= 0
    })
}

function $a(e) {
    var t = e.state,
        n = e.name,
        s = t.rects.reference,
        r = t.rects.popper,
        i = t.modifiersData.preventOverflow,
        o = Ht(t, {
            elementContext: "reference"
        }),
        a = Ht(t, {
            altBoundary: !0
        }),
        l = Ns(o, s),
        u = Ns(a, r, i),
        c = Ds(l),
        h = Ds(u);
    t.modifiersData[n] = {
        referenceClippingOffsets: l,
        popperEscapeOffsets: u,
        isReferenceHidden: c,
        hasPopperEscaped: h
    }, t.attributes.popper = Object.assign({}, t.attributes.popper, {
        "data-popper-reference-hidden": c,
        "data-popper-escaped": h
    })
}
const Jr = {
    name: "hide",
    enabled: !0,
    phase: "main",
    requiresIfExists: ["preventOverflow"],
    fn: $a
};

function Ia(e, t, n) {
    var s = Q(e),
        r = [P, x].indexOf(s) >= 0 ? -1 : 1,
        i = typeof n == "function" ? n(Object.assign({}, t, {
            placement: e
        })) : n,
        o = i[0],
        a = i[1];
    return o = o || 0, a = (a || 0) * r, [P, j].indexOf(s) >= 0 ? {
        x: a,
        y: o
    } : {
        x: o,
        y: a
    }
}

function xa(e) {
    var t = e.state,
        n = e.options,
        s = e.name,
        r = n.offset,
        i = r === void 0 ? [0, 0] : r,
        o = Vn.reduce(function(c, h) {
            return c[h] = Ia(h, t.rects, i), c
        }, {}),
        a = o[t.placement],
        l = a.x,
        u = a.y;
    t.modifiersData.popperOffsets != null && (t.modifiersData.popperOffsets.x += l, t.modifiersData.popperOffsets.y += u), t.modifiersData[s] = o
}
const Qr = {
    name: "offset",
    enabled: !0,
    phase: "main",
    requires: ["popperOffsets"],
    fn: xa
};

function Pa(e) {
    var t = e.state,
        n = e.name;
    t.modifiersData[n] = Gr({
        reference: t.rects.reference,
        element: t.rects.popper,
        strategy: "absolute",
        placement: t.placement
    })
}
const zn = {
    name: "popperOffsets",
    enabled: !0,
    phase: "read",
    fn: Pa,
    data: {}
};

function Ma(e) {
    return e === "x" ? "y" : "x"
}

function ka(e) {
    var t = e.state,
        n = e.options,
        s = e.name,
        r = n.mainAxis,
        i = r === void 0 ? !0 : r,
        o = n.altAxis,
        a = o === void 0 ? !1 : o,
        l = n.boundary,
        u = n.rootBoundary,
        c = n.altBoundary,
        h = n.padding,
        E = n.tether,
        g = E === void 0 ? !0 : E,
        m = n.tetherOffset,
        _ = m === void 0 ? 0 : m,
        p = Ht(t, {
            boundary: l,
            rootBoundary: u,
            padding: h,
            altBoundary: c
        }),
        T = Q(t.placement),
        O = Ft(t.placement),
        y = !O,
        b = jn(T),
        w = Ma(b),
        C = t.modifiersData.popperOffsets,
        S = t.rects.reference,
        N = t.rects.popper,
        L = typeof _ == "function" ? _(Object.assign({}, t.rects, {
            placement: t.placement
        })) : _,
        D = typeof L == "number" ? {
            mainAxis: L,
            altAxis: L
        } : Object.assign({
            mainAxis: 0,
            altAxis: 0
        }, L),
        $ = t.modifiersData.offset ? t.modifiersData.offset[t.placement] : null,
        z = {
            x: 0,
            y: 0
        };
    if (C) {
        if (i) {
            var I, pt = b === "y" ? x : P,
                mt = b === "y" ? B : j,
                V = b === "y" ? "height" : "width",
                G = C[b],
                fe = G + p[pt],
                _t = G - p[mt],
                de = g ? -N[V] / 2 : 0,
                Ye = O === Ot ? S[V] : N[V],
                Gt = O === Ot ? -N[V] : -S[V],
                he = t.elements.arrow,
                Dt = g && he ? Bn(he) : {
                    width: 0,
                    height: 0
                },
                it = t.modifiersData["arrow#persistent"] ? t.modifiersData["arrow#persistent"].padding : Wr(),
                Xt = it[pt],
                pe = it[mt],
                gt = te(0, S[V], Dt[V]),
                ze = y ? S[V] / 2 - de - gt - Xt - D.mainAxis : Ye - gt - Xt - D.mainAxis,
                Li = y ? -S[V] / 2 + de + gt + pe + D.mainAxis : Gt + gt + pe + D.mainAxis,
                Ge = t.elements.arrow && oe(t.elements.arrow),
                Ri = Ge ? b === "y" ? Ge.clientTop || 0 : Ge.clientLeft || 0 : 0,
                es = (I = $ == null ? void 0 : $[b]) != null ? I : 0,
                $i = G + ze - es - Ri,
                Ii = G + Li - es,
                ns = te(g ? Le(fe, $i) : fe, G, g ? Tt(_t, Ii) : _t);
            C[b] = ns, z[b] = ns - G
        }
        if (a) {
            var ss, xi = b === "x" ? x : P,
                Pi = b === "x" ? B : j,
                Et = C[w],
                me = w === "y" ? "height" : "width",
                rs = Et + p[xi],
                is = Et - p[Pi],
                Xe = [x, P].indexOf(T) !== -1,
                os = (ss = $ == null ? void 0 : $[w]) != null ? ss : 0,
                as = Xe ? rs : Et - S[me] - N[me] - os + D.altAxis,
                cs = Xe ? Et + S[me] + N[me] - os - D.altAxis : is,
                ls = g && Xe ? pa(as, Et, cs) : te(g ? as : rs, Et, g ? cs : is);
            C[w] = ls, z[w] = ls - Et
        }
        t.modifiersData[s] = z
    }
}
const Zr = {
    name: "preventOverflow",
    enabled: !0,
    phase: "main",
    fn: ka,
    requiresIfExists: ["offset"]
};

function Va(e) {
    return {
        scrollLeft: e.scrollLeft,
        scrollTop: e.scrollTop
    }
}

function Fa(e) {
    return e === U(e) || !W(e) ? Kn(e) : Va(e)
}

function Ha(e) {
    var t = e.getBoundingClientRect(),
        n = kt(t.width) / e.offsetWidth || 1,
        s = kt(t.height) / e.offsetHeight || 1;
    return n !== 1 || s !== 1
}

function Ba(e, t, n) {
    n === void 0 && (n = !1);
    var s = W(t),
        r = W(t) && Ha(t),
        i = ft(t),
        o = Vt(e, r, n),
        a = {
            scrollLeft: 0,
            scrollTop: 0
        },
        l = {
            x: 0,
            y: 0
        };
    return (s || !s && !n) && ((tt(t) !== "body" || Yn(i)) && (a = Fa(t)), W(t) ? (l = Vt(t, !0), l.x += t.clientLeft, l.y += t.clientTop) : i && (l.x = qn(i))), {
        x: o.left + a.scrollLeft - l.x,
        y: o.top + a.scrollTop - l.y,
        width: o.width,
        height: o.height
    }
}

function ja(e) {
    var t = new Map,
        n = new Set,
        s = [];
    e.forEach(function(i) {
        t.set(i.name, i)
    });

    function r(i) {
        n.add(i.name);
        var o = [].concat(i.requires || [], i.requiresIfExists || []);
        o.forEach(function(a) {
            if (!n.has(a)) {
                var l = t.get(a);
                l && r(l)
            }
        }), s.push(i)
    }
    return e.forEach(function(i) {
        n.has(i.name) || r(i)
    }), s
}

function Ua(e) {
    var t = ja(e);
    return Br.reduce(function(n, s) {
        return n.concat(t.filter(function(r) {
            return r.phase === s
        }))
    }, [])
}

function Wa(e) {
    var t;
    return function() {
        return t || (t = new Promise(function(n) {
            Promise.resolve().then(function() {
                t = void 0, n(e())
            })
        })), t
    }
}

function Ka(e) {
    var t = e.reduce(function(n, s) {
        var r = n[s.name];
        return n[s.name] = r ? Object.assign({}, r, s, {
            options: Object.assign({}, r.options, s.options),
            data: Object.assign({}, r.data, s.data)
        }) : s, n
    }, {});
    return Object.keys(t).map(function(n) {
        return t[n]
    })
}
var Ls = {
    placement: "bottom",
    modifiers: [],
    strategy: "absolute"
};

function Rs() {
    for (var e = arguments.length, t = new Array(e), n = 0; n < e; n++) t[n] = arguments[n];
    return !t.some(function(s) {
        return !(s && typeof s.getBoundingClientRect == "function")
    })
}

function Be(e) {
    e === void 0 && (e = {});
    var t = e,
        n = t.defaultModifiers,
        s = n === void 0 ? [] : n,
        r = t.defaultOptions,
        i = r === void 0 ? Ls : r;
    return function(a, l, u) {
        u === void 0 && (u = i);
        var c = {
                placement: "bottom",
                orderedModifiers: [],
                options: Object.assign({}, Ls, i),
                modifiersData: {},
                elements: {
                    reference: a,
                    popper: l
                },
                attributes: {},
                styles: {}
            },
            h = [],
            E = !1,
            g = {
                state: c,
                setOptions: function(T) {
                    var O = typeof T == "function" ? T(c.options) : T;
                    _(), c.options = Object.assign({}, i, c.options, O), c.scrollParents = {
                        reference: St(a) ? ee(a) : a.contextElement ? ee(a.contextElement) : [],
                        popper: ee(l)
                    };
                    var y = Ua(Ka([].concat(s, c.options.modifiers)));
                    return c.orderedModifiers = y.filter(function(b) {
                        return b.enabled
                    }), m(), g.update()
                },
                forceUpdate: function() {
                    if (!E) {
                        var T = c.elements,
                            O = T.reference,
                            y = T.popper;
                        if (Rs(O, y)) {
                            c.rects = {
                                reference: Ba(O, oe(y), c.options.strategy === "fixed"),
                                popper: Bn(y)
                            }, c.reset = !1, c.placement = c.options.placement, c.orderedModifiers.forEach(function(D) {
                                return c.modifiersData[D.name] = Object.assign({}, D.data)
                            });
                            for (var b = 0; b < c.orderedModifiers.length; b++) {
                                if (c.reset === !0) {
                                    c.reset = !1, b = -1;
                                    continue
                                }
                                var w = c.orderedModifiers[b],
                                    C = w.fn,
                                    S = w.options,
                                    N = S === void 0 ? {} : S,
                                    L = w.name;
                                typeof C == "function" && (c = C({
                                    state: c,
                                    options: N,
                                    name: L,
                                    instance: g
                                }) || c)
                            }
                        }
                    }
                },
                update: Wa(function() {
                    return new Promise(function(p) {
                        g.forceUpdate(), p(c)
                    })
                }),
                destroy: function() {
                    _(), E = !0
                }
            };
        if (!Rs(a, l)) return g;
        g.setOptions(u).then(function(p) {
            !E && u.onFirstUpdate && u.onFirstUpdate(p)
        });

        function m() {
            c.orderedModifiers.forEach(function(p) {
                var T = p.name,
                    O = p.options,
                    y = O === void 0 ? {} : O,
                    b = p.effect;
                if (typeof b == "function") {
                    var w = b({
                            state: c,
                            name: T,
                            instance: g,
                            options: y
                        }),
                        C = function() {};
                    h.push(w || C)
                }
            })
        }

        function _() {
            h.forEach(function(p) {
                return p()
            }), h = []
        }
        return g
    }
}
var qa = Be(),
    Ya = [Wn, zn, Un, Hn],
    za = Be({
        defaultModifiers: Ya
    }),
    Ga = [Wn, zn, Un, Hn, Qr, Xr, Zr, Yr, Jr],
    Gn = Be({
        defaultModifiers: Ga
    });
const ti = Object.freeze(Object.defineProperty({
    __proto__: null,
    afterMain: kr,
    afterRead: xr,
    afterWrite: Hr,
    applyStyles: Hn,
    arrow: Yr,
    auto: Fe,
    basePlacements: Kt,
    beforeMain: Pr,
    beforeRead: $r,
    beforeWrite: Vr,
    bottom: B,
    clippingParents: Lr,
    computeStyles: Un,
    createPopper: Gn,
    createPopperBase: qa,
    createPopperLite: za,
    detectOverflow: Ht,
    end: Mt,
    eventListeners: Wn,
    flip: Xr,
    hide: Jr,
    left: P,
    main: Mr,
    modifierPhases: Br,
    offset: Qr,
    placements: Vn,
    popper: $t,
    popperGenerator: Be,
    popperOffsets: zn,
    preventOverflow: Zr,
    read: Ir,
    reference: Rr,
    right: j,
    start: Ot,
    top: x,
    variationPlacements: On,
    viewport: kn,
    write: Fr
}, Symbol.toStringTag, {
    value: "Module"
}));
/*!
 * Bootstrap v5.3.3 (https://getbootstrap.com/)
 * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
 */
const at = new Map,
    en = {
        set(e, t, n) {
            at.has(e) || at.set(e, new Map);
            const s = at.get(e);
            if (!s.has(t) && s.size !== 0) {
                console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(s.keys())[0]}.`);
                return
            }
            s.set(t, n)
        },
        get(e, t) {
            return at.has(e) && at.get(e).get(t) || null
        },
        remove(e, t) {
            if (!at.has(e)) return;
            const n = at.get(e);
            n.delete(t), n.size === 0 && at.delete(e)
        }
    },
    Xa = 1e6,
    Ja = 1e3,
    Nn = "transitionend",
    ei = e => (e && window.CSS && window.CSS.escape && (e = e.replace(/#([^\s"#']+)/g, (t, n) => `#${CSS.escape(n)}`)), e),
    Qa = e => e == null ? `${e}` : Object.prototype.toString.call(e).match(/\s([a-z]+)/i)[1].toLowerCase(),
    Za = e => {
        do e += Math.floor(Math.random() * Xa); while (document.getElementById(e));
        return e
    },
    tc = e => {
        if (!e) return 0;
        let {
            transitionDuration: t,
            transitionDelay: n
        } = window.getComputedStyle(e);
        const s = Number.parseFloat(t),
            r = Number.parseFloat(n);
        return !s && !r ? 0 : (t = t.split(",")[0], n = n.split(",")[0], (Number.parseFloat(t) + Number.parseFloat(n)) * Ja)
    },
    ni = e => {
        e.dispatchEvent(new Event(Nn))
    },
    et = e => !e || typeof e != "object" ? !1 : (typeof e.jquery < "u" && (e = e[0]), typeof e.nodeType < "u"),
    ct = e => et(e) ? e.jquery ? e[0] : e : typeof e == "string" && e.length > 0 ? document.querySelector(ei(e)) : null,
    qt = e => {
        if (!et(e) || e.getClientRects().length === 0) return !1;
        const t = getComputedStyle(e).getPropertyValue("visibility") === "visible",
            n = e.closest("details:not([open])");
        if (!n) return t;
        if (n !== e) {
            const s = e.closest("summary");
            if (s && s.parentNode !== n || s === null) return !1
        }
        return t
    },
    lt = e => !e || e.nodeType !== Node.ELEMENT_NODE || e.classList.contains("disabled") ? !0 : typeof e.disabled < "u" ? e.disabled : e.hasAttribute("disabled") && e.getAttribute("disabled") !== "false",
    si = e => {
        if (!document.documentElement.attachShadow) return null;
        if (typeof e.getRootNode == "function") {
            const t = e.getRootNode();
            return t instanceof ShadowRoot ? t : null
        }
        return e instanceof ShadowRoot ? e : e.parentNode ? si(e.parentNode) : null
    },
    Re = () => {},
    ae = e => {
        e.offsetHeight
    },
    ri = () => window.jQuery && !document.body.hasAttribute("data-bs-no-jquery") ? window.jQuery : null,
    nn = [],
    ec = e => {
        document.readyState === "loading" ? (nn.length || document.addEventListener("DOMContentLoaded", () => {
            for (const t of nn) t()
        }), nn.push(e)) : e()
    },
    K = () => document.documentElement.dir === "rtl",
    Y = e => {
        ec(() => {
            const t = ri();
            if (t) {
                const n = e.NAME,
                    s = t.fn[n];
                t.fn[n] = e.jQueryInterface, t.fn[n].Constructor = e, t.fn[n].noConflict = () => (t.fn[n] = s, e.jQueryInterface)
            }
        })
    },
    M = (e, t = [], n = e) => typeof e == "function" ? e(...t) : n,
    ii = (e, t, n = !0) => {
        if (!n) {
            M(e);
            return
        }
        const r = tc(t) + 5;
        let i = !1;
        const o = ({
            target: a
        }) => {
            a === t && (i = !0, t.removeEventListener(Nn, o), M(e))
        };
        t.addEventListener(Nn, o), setTimeout(() => {
            i || ni(t)
        }, r)
    },
    Xn = (e, t, n, s) => {
        const r = e.length;
        let i = e.indexOf(t);
        return i === -1 ? !n && s ? e[r - 1] : e[0] : (i += n ? 1 : -1, s && (i = (i + r) % r), e[Math.max(0, Math.min(i, r - 1))])
    },
    nc = /[^.]*(?=\..*)\.|.*/,
    sc = /\..*/,
    rc = /::\d+$/,
    sn = {};
let $s = 1;
const oi = {
        mouseenter: "mouseover",
        mouseleave: "mouseout"
    },
    ic = new Set(["click", "dblclick", "mouseup", "mousedown", "contextmenu", "mousewheel", "DOMMouseScroll", "mouseover", "mouseout", "mousemove", "selectstart", "selectend", "keydown", "keypress", "keyup", "orientationchange", "touchstart", "touchmove", "touchend", "touchcancel", "pointerdown", "pointermove", "pointerup", "pointerleave", "pointercancel", "gesturestart", "gesturechange", "gestureend", "focus", "blur", "change", "reset", "select", "submit", "focusin", "focusout", "load", "unload", "beforeunload", "resize", "move", "DOMContentLoaded", "readystatechange", "error", "abort", "scroll"]);

function ai(e, t) {
    return t && `${t}::${$s++}` || e.uidEvent || $s++
}

function ci(e) {
    const t = ai(e);
    return e.uidEvent = t, sn[t] = sn[t] || {}, sn[t]
}

function oc(e, t) {
    return function n(s) {
        return Jn(s, {
            delegateTarget: e
        }), n.oneOff && d.off(e, s.type, t), t.apply(e, [s])
    }
}

function ac(e, t, n) {
    return function s(r) {
        const i = e.querySelectorAll(t);
        for (let {
                target: o
            } = r; o && o !== this; o = o.parentNode)
            for (const a of i)
                if (a === o) return Jn(r, {
                    delegateTarget: o
                }), s.oneOff && d.off(e, r.type, t, n), n.apply(o, [r])
    }
}

function li(e, t, n = null) {
    return Object.values(e).find(s => s.callable === t && s.delegationSelector === n)
}

function ui(e, t, n) {
    const s = typeof t == "string",
        r = s ? n : t || n;
    let i = fi(e);
    return ic.has(i) || (i = e), [s, r, i]
}

function Is(e, t, n, s, r) {
    if (typeof t != "string" || !e) return;
    let [i, o, a] = ui(t, n, s);
    t in oi && (o = (m => function(_) {
        if (!_.relatedTarget || _.relatedTarget !== _.delegateTarget && !_.delegateTarget.contains(_.relatedTarget)) return m.call(this, _)
    })(o));
    const l = ci(e),
        u = l[a] || (l[a] = {}),
        c = li(u, o, i ? n : null);
    if (c) {
        c.oneOff = c.oneOff && r;
        return
    }
    const h = ai(o, t.replace(nc, "")),
        E = i ? ac(e, n, o) : oc(e, o);
    E.delegationSelector = i ? n : null, E.callable = o, E.oneOff = r, E.uidEvent = h, u[h] = E, e.addEventListener(a, E, i)
}

function Dn(e, t, n, s, r) {
    const i = li(t[n], s, r);
    i && (e.removeEventListener(n, i, !!r), delete t[n][i.uidEvent])
}

function cc(e, t, n, s) {
    const r = t[n] || {};
    for (const [i, o] of Object.entries(r)) i.includes(s) && Dn(e, t, n, o.callable, o.delegationSelector)
}

function fi(e) {
    return e = e.replace(sc, ""), oi[e] || e
}
const d = {
    on(e, t, n, s) {
        Is(e, t, n, s, !1)
    },
    one(e, t, n, s) {
        Is(e, t, n, s, !0)
    },
    off(e, t, n, s) {
        if (typeof t != "string" || !e) return;
        const [r, i, o] = ui(t, n, s), a = o !== t, l = ci(e), u = l[o] || {}, c = t.startsWith(".");
        if (typeof i < "u") {
            if (!Object.keys(u).length) return;
            Dn(e, l, o, i, r ? n : null);
            return
        }
        if (c)
            for (const h of Object.keys(l)) cc(e, l, h, t.slice(1));
        for (const [h, E] of Object.entries(u)) {
            const g = h.replace(rc, "");
            (!a || t.includes(g)) && Dn(e, l, o, E.callable, E.delegationSelector)
        }
    },
    trigger(e, t, n) {
        if (typeof t != "string" || !e) return null;
        const s = ri(),
            r = fi(t),
            i = t !== r;
        let o = null,
            a = !0,
            l = !0,
            u = !1;
        i && s && (o = s.Event(t, n), s(e).trigger(o), a = !o.isPropagationStopped(), l = !o.isImmediatePropagationStopped(), u = o.isDefaultPrevented());
        const c = Jn(new Event(t, {
            bubbles: a,
            cancelable: !0
        }), n);
        return u && c.preventDefault(), l && e.dispatchEvent(c), c.defaultPrevented && o && o.preventDefault(), c
    }
};

function Jn(e, t = {}) {
    for (const [n, s] of Object.entries(t)) try {
        e[n] = s
    } catch {
        Object.defineProperty(e, n, {
            configurable: !0,
            get() {
                return s
            }
        })
    }
    return e
}

function xs(e) {
    if (e === "true") return !0;
    if (e === "false") return !1;
    if (e === Number(e).toString()) return Number(e);
    if (e === "" || e === "null") return null;
    if (typeof e != "string") return e;
    try {
        return JSON.parse(decodeURIComponent(e))
    } catch {
        return e
    }
}

function rn(e) {
    return e.replace(/[A-Z]/g, t => `-${t.toLowerCase()}`)
}
const nt = {
    setDataAttribute(e, t, n) {
        e.setAttribute(`data-bs-${rn(t)}`, n)
    },
    removeDataAttribute(e, t) {
        e.removeAttribute(`data-bs-${rn(t)}`)
    },
    getDataAttributes(e) {
        if (!e) return {};
        const t = {},
            n = Object.keys(e.dataset).filter(s => s.startsWith("bs") && !s.startsWith("bsConfig"));
        for (const s of n) {
            let r = s.replace(/^bs/, "");
            r = r.charAt(0).toLowerCase() + r.slice(1, r.length), t[r] = xs(e.dataset[s])
        }
        return t
    },
    getDataAttribute(e, t) {
        return xs(e.getAttribute(`data-bs-${rn(t)}`))
    }
};
class ce {
    static get Default() {
        return {}
    }
    static get DefaultType() {
        return {}
    }
    static get NAME() {
        throw new Error('You have to implement the static method "NAME", for each component!')
    }
    _getConfig(t) {
        return t = this._mergeConfigObj(t), t = this._configAfterMerge(t), this._typeCheckConfig(t), t
    }
    _configAfterMerge(t) {
        return t
    }
    _mergeConfigObj(t, n) {
        const s = et(n) ? nt.getDataAttribute(n, "config") : {};
        return {
            ...this.constructor.Default,
            ...typeof s == "object" ? s : {},
            ...et(n) ? nt.getDataAttributes(n) : {},
            ...typeof t == "object" ? t : {}
        }
    }
    _typeCheckConfig(t, n = this.constructor.DefaultType) {
        for (const [s, r] of Object.entries(n)) {
            const i = t[s],
                o = et(i) ? "element" : Qa(i);
            if (!new RegExp(r).test(o)) throw new TypeError(`${this.constructor.NAME.toUpperCase()}: Option "${s}" provided type "${o}" but expected type "${r}".`)
        }
    }
}
const lc = "5.3.3";
class J extends ce {
    constructor(t, n) {
        super(), t = ct(t), t && (this._element = t, this._config = this._getConfig(n), en.set(this._element, this.constructor.DATA_KEY, this))
    }
    dispose() {
        en.remove(this._element, this.constructor.DATA_KEY), d.off(this._element, this.constructor.EVENT_KEY);
        for (const t of Object.getOwnPropertyNames(this)) this[t] = null
    }
    _queueCallback(t, n, s = !0) {
        ii(t, n, s)
    }
    _getConfig(t) {
        return t = this._mergeConfigObj(t, this._element), t = this._configAfterMerge(t), this._typeCheckConfig(t), t
    }
    static getInstance(t) {
        return en.get(ct(t), this.DATA_KEY)
    }
    static getOrCreateInstance(t, n = {}) {
        return this.getInstance(t) || new this(t, typeof n == "object" ? n : null)
    }
    static get VERSION() {
        return lc
    }
    static get DATA_KEY() {
        return `bs.${this.NAME}`
    }
    static get EVENT_KEY() {
        return `.${this.DATA_KEY}`
    }
    static eventName(t) {
        return `${t}${this.EVENT_KEY}`
    }
}
const on = e => {
        let t = e.getAttribute("data-bs-target");
        if (!t || t === "#") {
            let n = e.getAttribute("href");
            if (!n || !n.includes("#") && !n.startsWith(".")) return null;
            n.includes("#") && !n.startsWith("#") && (n = `#${n.split("#")[1]}`), t = n && n !== "#" ? n.trim() : null
        }
        return t ? t.split(",").map(n => ei(n)).join(",") : null
    },
    v = {
        find(e, t = document.documentElement) {
            return [].concat(...Element.prototype.querySelectorAll.call(t, e))
        },
        findOne(e, t = document.documentElement) {
            return Element.prototype.querySelector.call(t, e)
        },
        children(e, t) {
            return [].concat(...e.children).filter(n => n.matches(t))
        },
        parents(e, t) {
            const n = [];
            let s = e.parentNode.closest(t);
            for (; s;) n.push(s), s = s.parentNode.closest(t);
            return n
        },
        prev(e, t) {
            let n = e.previousElementSibling;
            for (; n;) {
                if (n.matches(t)) return [n];
                n = n.previousElementSibling
            }
            return []
        },
        next(e, t) {
            let n = e.nextElementSibling;
            for (; n;) {
                if (n.matches(t)) return [n];
                n = n.nextElementSibling
            }
            return []
        },
        focusableChildren(e) {
            const t = ["a", "button", "input", "textarea", "select", "details", "[tabindex]", '[contenteditable="true"]'].map(n => `${n}:not([tabindex^="-"])`).join(",");
            return this.find(t, e).filter(n => !lt(n) && qt(n))
        },
        getSelectorFromElement(e) {
            const t = on(e);
            return t && v.findOne(t) ? t : null
        },
        getElementFromSelector(e) {
            const t = on(e);
            return t ? v.findOne(t) : null
        },
        getMultipleElementsFromSelector(e) {
            const t = on(e);
            return t ? v.find(t) : []
        }
    },
    je = (e, t = "hide") => {
        const n = `click.dismiss${e.EVENT_KEY}`,
            s = e.NAME;
        d.on(document, n, `[data-bs-dismiss="${s}"]`, function(r) {
            if (["A", "AREA"].includes(this.tagName) && r.preventDefault(), lt(this)) return;
            const i = v.getElementFromSelector(this) || this.closest(`.${s}`);
            e.getOrCreateInstance(i)[t]()
        })
    },
    uc = "alert",
    fc = "bs.alert",
    di = `.${fc}`,
    dc = `close${di}`,
    hc = `closed${di}`,
    pc = "fade",
    mc = "show";
class Ue extends J {
    static get NAME() {
        return uc
    }
    close() {
        if (d.trigger(this._element, dc).defaultPrevented) return;
        this._element.classList.remove(mc);
        const n = this._element.classList.contains(pc);
        this._queueCallback(() => this._destroyElement(), this._element, n)
    }
    _destroyElement() {
        this._element.remove(), d.trigger(this._element, hc), this.dispose()
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = Ue.getOrCreateInstance(this);
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor") throw new TypeError(`No method named "${t}"`);
                n[t](this)
            }
        })
    }
}
je(Ue, "close");
Y(Ue);
const _c = "button",
    gc = "bs.button",
    Ec = `.${gc}`,
    bc = ".data-api",
    vc = "active",
    Ps = '[data-bs-toggle="button"]',
    yc = `click${Ec}${bc}`;
class We extends J {
    static get NAME() {
        return _c
    }
    toggle() {
        this._element.setAttribute("aria-pressed", this._element.classList.toggle(vc))
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = We.getOrCreateInstance(this);
            t === "toggle" && n[t]()
        })
    }
}
d.on(document, yc, Ps, e => {
    e.preventDefault();
    const t = e.target.closest(Ps);
    We.getOrCreateInstance(t).toggle()
});
Y(We);
const Ac = "swipe",
    Yt = ".bs.swipe",
    Tc = `touchstart${Yt}`,
    wc = `touchmove${Yt}`,
    Oc = `touchend${Yt}`,
    Sc = `pointerdown${Yt}`,
    Cc = `pointerup${Yt}`,
    Nc = "touch",
    Dc = "pen",
    Lc = "pointer-event",
    Rc = 40,
    $c = {
        endCallback: null,
        leftCallback: null,
        rightCallback: null
    },
    Ic = {
        endCallback: "(function|null)",
        leftCallback: "(function|null)",
        rightCallback: "(function|null)"
    };
class $e extends ce {
    constructor(t, n) {
        super(), this._element = t, !(!t || !$e.isSupported()) && (this._config = this._getConfig(n), this._deltaX = 0, this._supportPointerEvents = !!window.PointerEvent, this._initEvents())
    }
    static get Default() {
        return $c
    }
    static get DefaultType() {
        return Ic
    }
    static get NAME() {
        return Ac
    }
    dispose() {
        d.off(this._element, Yt)
    }
    _start(t) {
        if (!this._supportPointerEvents) {
            this._deltaX = t.touches[0].clientX;
            return
        }
        this._eventIsPointerPenTouch(t) && (this._deltaX = t.clientX)
    }
    _end(t) {
        this._eventIsPointerPenTouch(t) && (this._deltaX = t.clientX - this._deltaX), this._handleSwipe(), M(this._config.endCallback)
    }
    _move(t) {
        this._deltaX = t.touches && t.touches.length > 1 ? 0 : t.touches[0].clientX - this._deltaX
    }
    _handleSwipe() {
        const t = Math.abs(this._deltaX);
        if (t <= Rc) return;
        const n = t / this._deltaX;
        this._deltaX = 0, n && M(n > 0 ? this._config.rightCallback : this._config.leftCallback)
    }
    _initEvents() {
        this._supportPointerEvents ? (d.on(this._element, Sc, t => this._start(t)), d.on(this._element, Cc, t => this._end(t)), this._element.classList.add(Lc)) : (d.on(this._element, Tc, t => this._start(t)), d.on(this._element, wc, t => this._move(t)), d.on(this._element, Oc, t => this._end(t)))
    }
    _eventIsPointerPenTouch(t) {
        return this._supportPointerEvents && (t.pointerType === Dc || t.pointerType === Nc)
    }
    static isSupported() {
        return "ontouchstart" in document.documentElement || navigator.maxTouchPoints > 0
    }
}
const xc = "carousel",
    Pc = "bs.carousel",
    dt = `.${Pc}`,
    hi = ".data-api",
    Mc = "ArrowLeft",
    kc = "ArrowRight",
    Vc = 500,
    Qt = "next",
    Lt = "prev",
    It = "left",
    Se = "right",
    Fc = `slide${dt}`,
    an = `slid${dt}`,
    Hc = `keydown${dt}`,
    Bc = `mouseenter${dt}`,
    jc = `mouseleave${dt}`,
    Uc = `dragstart${dt}`,
    Wc = `load${dt}${hi}`,
    Kc = `click${dt}${hi}`,
    pi = "carousel",
    ge = "active",
    qc = "slide",
    Yc = "carousel-item-end",
    zc = "carousel-item-start",
    Gc = "carousel-item-next",
    Xc = "carousel-item-prev",
    mi = ".active",
    _i = ".carousel-item",
    Jc = mi + _i,
    Qc = ".carousel-item img",
    Zc = ".carousel-indicators",
    tl = "[data-bs-slide], [data-bs-slide-to]",
    el = '[data-bs-ride="carousel"]',
    nl = {
        [Mc]: Se,
        [kc]: It
    },
    sl = {
        interval: 5e3,
        keyboard: !0,
        pause: "hover",
        ride: !1,
        touch: !0,
        wrap: !0
    },
    rl = {
        interval: "(number|boolean)",
        keyboard: "boolean",
        pause: "(string|boolean)",
        ride: "(boolean|string)",
        touch: "boolean",
        wrap: "boolean"
    };
class le extends J {
    constructor(t, n) {
        super(t, n), this._interval = null, this._activeElement = null, this._isSliding = !1, this.touchTimeout = null, this._swipeHelper = null, this._indicatorsElement = v.findOne(Zc, this._element), this._addEventListeners(), this._config.ride === pi && this.cycle()
    }
    static get Default() {
        return sl
    }
    static get DefaultType() {
        return rl
    }
    static get NAME() {
        return xc
    }
    next() {
        this._slide(Qt)
    }
    nextWhenVisible() {
        !document.hidden && qt(this._element) && this.next()
    }
    prev() {
        this._slide(Lt)
    }
    pause() {
        this._isSliding && ni(this._element), this._clearInterval()
    }
    cycle() {
        this._clearInterval(), this._updateInterval(), this._interval = setInterval(() => this.nextWhenVisible(), this._config.interval)
    }
    _maybeEnableCycle() {
        if (this._config.ride) {
            if (this._isSliding) {
                d.one(this._element, an, () => this.cycle());
                return
            }
            this.cycle()
        }
    }
    to(t) {
        const n = this._getItems();
        if (t > n.length - 1 || t < 0) return;
        if (this._isSliding) {
            d.one(this._element, an, () => this.to(t));
            return
        }
        const s = this._getItemIndex(this._getActive());
        if (s === t) return;
        const r = t > s ? Qt : Lt;
        this._slide(r, n[t])
    }
    dispose() {
        this._swipeHelper && this._swipeHelper.dispose(), super.dispose()
    }
    _configAfterMerge(t) {
        return t.defaultInterval = t.interval, t
    }
    _addEventListeners() {
        this._config.keyboard && d.on(this._element, Hc, t => this._keydown(t)), this._config.pause === "hover" && (d.on(this._element, Bc, () => this.pause()), d.on(this._element, jc, () => this._maybeEnableCycle())), this._config.touch && $e.isSupported() && this._addTouchEventListeners()
    }
    _addTouchEventListeners() {
        for (const s of v.find(Qc, this._element)) d.on(s, Uc, r => r.preventDefault());
        const n = {
            leftCallback: () => this._slide(this._directionToOrder(It)),
            rightCallback: () => this._slide(this._directionToOrder(Se)),
            endCallback: () => {
                this._config.pause === "hover" && (this.pause(), this.touchTimeout && clearTimeout(this.touchTimeout), this.touchTimeout = setTimeout(() => this._maybeEnableCycle(), Vc + this._config.interval))
            }
        };
        this._swipeHelper = new $e(this._element, n)
    }
    _keydown(t) {
        if (/input|textarea/i.test(t.target.tagName)) return;
        const n = nl[t.key];
        n && (t.preventDefault(), this._slide(this._directionToOrder(n)))
    }
    _getItemIndex(t) {
        return this._getItems().indexOf(t)
    }
    _setActiveIndicatorElement(t) {
        if (!this._indicatorsElement) return;
        const n = v.findOne(mi, this._indicatorsElement);
        n.classList.remove(ge), n.removeAttribute("aria-current");
        const s = v.findOne(`[data-bs-slide-to="${t}"]`, this._indicatorsElement);
        s && (s.classList.add(ge), s.setAttribute("aria-current", "true"))
    }
    _updateInterval() {
        const t = this._activeElement || this._getActive();
        if (!t) return;
        const n = Number.parseInt(t.getAttribute("data-bs-interval"), 10);
        this._config.interval = n || this._config.defaultInterval
    }
    _slide(t, n = null) {
        if (this._isSliding) return;
        const s = this._getActive(),
            r = t === Qt,
            i = n || Xn(this._getItems(), s, r, this._config.wrap);
        if (i === s) return;
        const o = this._getItemIndex(i),
            a = g => d.trigger(this._element, g, {
                relatedTarget: i,
                direction: this._orderToDirection(t),
                from: this._getItemIndex(s),
                to: o
            });
        if (a(Fc).defaultPrevented || !s || !i) return;
        const u = !!this._interval;
        this.pause(), this._isSliding = !0, this._setActiveIndicatorElement(o), this._activeElement = i;
        const c = r ? zc : Yc,
            h = r ? Gc : Xc;
        i.classList.add(h), ae(i), s.classList.add(c), i.classList.add(c);
        const E = () => {
            i.classList.remove(c, h), i.classList.add(ge), s.classList.remove(ge, h, c), this._isSliding = !1, a(an)
        };
        this._queueCallback(E, s, this._isAnimated()), u && this.cycle()
    }
    _isAnimated() {
        return this._element.classList.contains(qc)
    }
    _getActive() {
        return v.findOne(Jc, this._element)
    }
    _getItems() {
        return v.find(_i, this._element)
    }
    _clearInterval() {
        this._interval && (clearInterval(this._interval), this._interval = null)
    }
    _directionToOrder(t) {
        return K() ? t === It ? Lt : Qt : t === It ? Qt : Lt
    }
    _orderToDirection(t) {
        return K() ? t === Lt ? It : Se : t === Lt ? Se : It
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = le.getOrCreateInstance(this, t);
            if (typeof t == "number") {
                n.to(t);
                return
            }
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor") throw new TypeError(`No method named "${t}"`);
                n[t]()
            }
        })
    }
}
d.on(document, Kc, tl, function(e) {
    const t = v.getElementFromSelector(this);
    if (!t || !t.classList.contains(pi)) return;
    e.preventDefault();
    const n = le.getOrCreateInstance(t),
        s = this.getAttribute("data-bs-slide-to");
    if (s) {
        n.to(s), n._maybeEnableCycle();
        return
    }
    if (nt.getDataAttribute(this, "slide") === "next") {
        n.next(), n._maybeEnableCycle();
        return
    }
    n.prev(), n._maybeEnableCycle()
});
d.on(window, Wc, () => {
    const e = v.find(el);
    for (const t of e) le.getOrCreateInstance(t)
});
Y(le);
const il = "collapse",
    ol = "bs.collapse",
    ue = `.${ol}`,
    al = ".data-api",
    cl = `show${ue}`,
    ll = `shown${ue}`,
    ul = `hide${ue}`,
    fl = `hidden${ue}`,
    dl = `click${ue}${al}`,
    cn = "show",
    Pt = "collapse",
    Ee = "collapsing",
    hl = "collapsed",
    pl = `:scope .${Pt} .${Pt}`,
    ml = "collapse-horizontal",
    _l = "width",
    gl = "height",
    El = ".collapse.show, .collapse.collapsing",
    Ln = '[data-bs-toggle="collapse"]',
    bl = {
        parent: null,
        toggle: !0
    },
    vl = {
        parent: "(null|element)",
        toggle: "boolean"
    };
class se extends J {
    constructor(t, n) {
        super(t, n), this._isTransitioning = !1, this._triggerArray = [];
        const s = v.find(Ln);
        for (const r of s) {
            const i = v.getSelectorFromElement(r),
                o = v.find(i).filter(a => a === this._element);
            i !== null && o.length && this._triggerArray.push(r)
        }
        this._initializeChildren(), this._config.parent || this._addAriaAndCollapsedClass(this._triggerArray, this._isShown()), this._config.toggle && this.toggle()
    }
    static get Default() {
        return bl
    }
    static get DefaultType() {
        return vl
    }
    static get NAME() {
        return il
    }
    toggle() {
        this._isShown() ? this.hide() : this.show()
    }
    show() {
        if (this._isTransitioning || this._isShown()) return;
        let t = [];
        if (this._config.parent && (t = this._getFirstLevelChildren(El).filter(a => a !== this._element).map(a => se.getOrCreateInstance(a, {
                toggle: !1
            }))), t.length && t[0]._isTransitioning || d.trigger(this._element, cl).defaultPrevented) return;
        for (const a of t) a.hide();
        const s = this._getDimension();
        this._element.classList.remove(Pt), this._element.classList.add(Ee), this._element.style[s] = 0, this._addAriaAndCollapsedClass(this._triggerArray, !0), this._isTransitioning = !0;
        const r = () => {
                this._isTransitioning = !1, this._element.classList.remove(Ee), this._element.classList.add(Pt, cn), this._element.style[s] = "", d.trigger(this._element, ll)
            },
            o = `scroll${s[0].toUpperCase()+s.slice(1)}`;
        this._queueCallback(r, this._element, !0), this._element.style[s] = `${this._element[o]}px`
    }
    hide() {
        if (this._isTransitioning || !this._isShown() || d.trigger(this._element, ul).defaultPrevented) return;
        const n = this._getDimension();
        this._element.style[n] = `${this._element.getBoundingClientRect()[n]}px`, ae(this._element), this._element.classList.add(Ee), this._element.classList.remove(Pt, cn);
        for (const r of this._triggerArray) {
            const i = v.getElementFromSelector(r);
            i && !this._isShown(i) && this._addAriaAndCollapsedClass([r], !1)
        }
        this._isTransitioning = !0;
        const s = () => {
            this._isTransitioning = !1, this._element.classList.remove(Ee), this._element.classList.add(Pt), d.trigger(this._element, fl)
        };
        this._element.style[n] = "", this._queueCallback(s, this._element, !0)
    }
    _isShown(t = this._element) {
        return t.classList.contains(cn)
    }
    _configAfterMerge(t) {
        return t.toggle = !!t.toggle, t.parent = ct(t.parent), t
    }
    _getDimension() {
        return this._element.classList.contains(ml) ? _l : gl
    }
    _initializeChildren() {
        if (!this._config.parent) return;
        const t = this._getFirstLevelChildren(Ln);
        for (const n of t) {
            const s = v.getElementFromSelector(n);
            s && this._addAriaAndCollapsedClass([n], this._isShown(s))
        }
    }
    _getFirstLevelChildren(t) {
        const n = v.find(pl, this._config.parent);
        return v.find(t, this._config.parent).filter(s => !n.includes(s))
    }
    _addAriaAndCollapsedClass(t, n) {
        if (t.length)
            for (const s of t) s.classList.toggle(hl, !n), s.setAttribute("aria-expanded", n)
    }
    static jQueryInterface(t) {
        const n = {};
        return typeof t == "string" && /show|hide/.test(t) && (n.toggle = !1), this.each(function() {
            const s = se.getOrCreateInstance(this, n);
            if (typeof t == "string") {
                if (typeof s[t] > "u") throw new TypeError(`No method named "${t}"`);
                s[t]()
            }
        })
    }
}
d.on(document, dl, Ln, function(e) {
    (e.target.tagName === "A" || e.delegateTarget && e.delegateTarget.tagName === "A") && e.preventDefault();
    for (const t of v.getMultipleElementsFromSelector(this)) se.getOrCreateInstance(t, {
        toggle: !1
    }).toggle()
});
Y(se);
const Ms = "dropdown",
    yl = "bs.dropdown",
    Ct = `.${yl}`,
    Qn = ".data-api",
    Al = "Escape",
    ks = "Tab",
    Tl = "ArrowUp",
    Vs = "ArrowDown",
    wl = 2,
    Ol = `hide${Ct}`,
    Sl = `hidden${Ct}`,
    Cl = `show${Ct}`,
    Nl = `shown${Ct}`,
    gi = `click${Ct}${Qn}`,
    Ei = `keydown${Ct}${Qn}`,
    Dl = `keyup${Ct}${Qn}`,
    xt = "show",
    Ll = "dropup",
    Rl = "dropend",
    $l = "dropstart",
    Il = "dropup-center",
    xl = "dropdown-center",
    vt = '[data-bs-toggle="dropdown"]:not(.disabled):not(:disabled)',
    Pl = `${vt}.${xt}`,
    Ce = ".dropdown-menu",
    Ml = ".navbar",
    kl = ".navbar-nav",
    Vl = ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)",
    Fl = K() ? "top-end" : "top-start",
    Hl = K() ? "top-start" : "top-end",
    Bl = K() ? "bottom-end" : "bottom-start",
    jl = K() ? "bottom-start" : "bottom-end",
    Ul = K() ? "left-start" : "right-start",
    Wl = K() ? "right-start" : "left-start",
    Kl = "top",
    ql = "bottom",
    Yl = {
        autoClose: !0,
        boundary: "clippingParents",
        display: "dynamic",
        offset: [0, 2],
        popperConfig: null,
        reference: "toggle"
    },
    zl = {
        autoClose: "(boolean|string)",
        boundary: "(string|element)",
        display: "string",
        offset: "(array|string|function)",
        popperConfig: "(null|object|function)",
        reference: "(string|element|object)"
    };
class Z extends J {
    constructor(t, n) {
        super(t, n), this._popper = null, this._parent = this._element.parentNode, this._menu = v.next(this._element, Ce)[0] || v.prev(this._element, Ce)[0] || v.findOne(Ce, this._parent), this._inNavbar = this._detectNavbar()
    }
    static get Default() {
        return Yl
    }
    static get DefaultType() {
        return zl
    }
    static get NAME() {
        return Ms
    }
    toggle() {
        return this._isShown() ? this.hide() : this.show()
    }
    show() {
        if (lt(this._element) || this._isShown()) return;
        const t = {
            relatedTarget: this._element
        };
        if (!d.trigger(this._element, Cl, t).defaultPrevented) {
            if (this._createPopper(), "ontouchstart" in document.documentElement && !this._parent.closest(kl))
                for (const s of [].concat(...document.body.children)) d.on(s, "mouseover", Re);
            this._element.focus(), this._element.setAttribute("aria-expanded", !0), this._menu.classList.add(xt), this._element.classList.add(xt), d.trigger(this._element, Nl, t)
        }
    }
    hide() {
        if (lt(this._element) || !this._isShown()) return;
        const t = {
            relatedTarget: this._element
        };
        this._completeHide(t)
    }
    dispose() {
        this._popper && this._popper.destroy(), super.dispose()
    }
    update() {
        this._inNavbar = this._detectNavbar(), this._popper && this._popper.update()
    }
    _completeHide(t) {
        if (!d.trigger(this._element, Ol, t).defaultPrevented) {
            if ("ontouchstart" in document.documentElement)
                for (const s of [].concat(...document.body.children)) d.off(s, "mouseover", Re);
            this._popper && this._popper.destroy(), this._menu.classList.remove(xt), this._element.classList.remove(xt), this._element.setAttribute("aria-expanded", "false"), nt.removeDataAttribute(this._menu, "popper"), d.trigger(this._element, Sl, t)
        }
    }
    _getConfig(t) {
        if (t = super._getConfig(t), typeof t.reference == "object" && !et(t.reference) && typeof t.reference.getBoundingClientRect != "function") throw new TypeError(`${Ms.toUpperCase()}: Option "reference" provided type "object" without a required "getBoundingClientRect" method.`);
        return t
    }
    _createPopper() {
        if (typeof ti > "u") throw new TypeError("Bootstrap's dropdowns require Popper (https://popper.js.org)");
        let t = this._element;
        this._config.reference === "parent" ? t = this._parent : et(this._config.reference) ? t = ct(this._config.reference) : typeof this._config.reference == "object" && (t = this._config.reference);
        const n = this._getPopperConfig();
        this._popper = Gn(t, this._menu, n)
    }
    _isShown() {
        return this._menu.classList.contains(xt)
    }
    _getPlacement() {
        const t = this._parent;
        if (t.classList.contains(Rl)) return Ul;
        if (t.classList.contains($l)) return Wl;
        if (t.classList.contains(Il)) return Kl;
        if (t.classList.contains(xl)) return ql;
        const n = getComputedStyle(this._menu).getPropertyValue("--bs-position").trim() === "end";
        return t.classList.contains(Ll) ? n ? Hl : Fl : n ? jl : Bl
    }
    _detectNavbar() {
        return this._element.closest(Ml) !== null
    }
    _getOffset() {
        const {
            offset: t
        } = this._config;
        return typeof t == "string" ? t.split(",").map(n => Number.parseInt(n, 10)) : typeof t == "function" ? n => t(n, this._element) : t
    }
    _getPopperConfig() {
        const t = {
            placement: this._getPlacement(),
            modifiers: [{
                name: "preventOverflow",
                options: {
                    boundary: this._config.boundary
                }
            }, {
                name: "offset",
                options: {
                    offset: this._getOffset()
                }
            }]
        };
        return (this._inNavbar || this._config.display === "static") && (nt.setDataAttribute(this._menu, "popper", "static"), t.modifiers = [{
            name: "applyStyles",
            enabled: !1
        }]), {
            ...t,
            ...M(this._config.popperConfig, [t])
        }
    }
    _selectMenuItem({
        key: t,
        target: n
    }) {
        const s = v.find(Vl, this._menu).filter(r => qt(r));
        s.length && Xn(s, n, t === Vs, !s.includes(n)).focus()
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = Z.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof n[t] > "u") throw new TypeError(`No method named "${t}"`);
                n[t]()
            }
        })
    }
    static clearMenus(t) {
        if (t.button === wl || t.type === "keyup" && t.key !== ks) return;
        const n = v.find(Pl);
        for (const s of n) {
            const r = Z.getInstance(s);
            if (!r || r._config.autoClose === !1) continue;
            const i = t.composedPath(),
                o = i.includes(r._menu);
            if (i.includes(r._element) || r._config.autoClose === "inside" && !o || r._config.autoClose === "outside" && o || r._menu.contains(t.target) && (t.type === "keyup" && t.key === ks || /input|select|option|textarea|form/i.test(t.target.tagName))) continue;
            const a = {
                relatedTarget: r._element
            };
            t.type === "click" && (a.clickEvent = t), r._completeHide(a)
        }
    }
    static dataApiKeydownHandler(t) {
        const n = /input|textarea/i.test(t.target.tagName),
            s = t.key === Al,
            r = [Tl, Vs].includes(t.key);
        if (!r && !s || n && !s) return;
        t.preventDefault();
        const i = this.matches(vt) ? this : v.prev(this, vt)[0] || v.next(this, vt)[0] || v.findOne(vt, t.delegateTarget.parentNode),
            o = Z.getOrCreateInstance(i);
        if (r) {
            t.stopPropagation(), o.show(), o._selectMenuItem(t);
            return
        }
        o._isShown() && (t.stopPropagation(), o.hide(), i.focus())
    }
}
d.on(document, Ei, vt, Z.dataApiKeydownHandler);
d.on(document, Ei, Ce, Z.dataApiKeydownHandler);
d.on(document, gi, Z.clearMenus);
d.on(document, Dl, Z.clearMenus);
d.on(document, gi, vt, function(e) {
    e.preventDefault(), Z.getOrCreateInstance(this).toggle()
});
Y(Z);
const bi = "backdrop",
    Gl = "fade",
    Fs = "show",
    Hs = `mousedown.bs.${bi}`,
    Xl = {
        className: "modal-backdrop",
        clickCallback: null,
        isAnimated: !1,
        isVisible: !0,
        rootElement: "body"
    },
    Jl = {
        className: "string",
        clickCallback: "(function|null)",
        isAnimated: "boolean",
        isVisible: "boolean",
        rootElement: "(element|string)"
    };
class vi extends ce {
    constructor(t) {
        super(), this._config = this._getConfig(t), this._isAppended = !1, this._element = null
    }
    static get Default() {
        return Xl
    }
    static get DefaultType() {
        return Jl
    }
    static get NAME() {
        return bi
    }
    show(t) {
        if (!this._config.isVisible) {
            M(t);
            return
        }
        this._append();
        const n = this._getElement();
        this._config.isAnimated && ae(n), n.classList.add(Fs), this._emulateAnimation(() => {
            M(t)
        })
    }
    hide(t) {
        if (!this._config.isVisible) {
            M(t);
            return
        }
        this._getElement().classList.remove(Fs), this._emulateAnimation(() => {
            this.dispose(), M(t)
        })
    }
    dispose() {
        this._isAppended && (d.off(this._element, Hs), this._element.remove(), this._isAppended = !1)
    }
    _getElement() {
        if (!this._element) {
            const t = document.createElement("div");
            t.className = this._config.className, this._config.isAnimated && t.classList.add(Gl), this._element = t
        }
        return this._element
    }
    _configAfterMerge(t) {
        return t.rootElement = ct(t.rootElement), t
    }
    _append() {
        if (this._isAppended) return;
        const t = this._getElement();
        this._config.rootElement.append(t), d.on(t, Hs, () => {
            M(this._config.clickCallback)
        }), this._isAppended = !0
    }
    _emulateAnimation(t) {
        ii(t, this._getElement(), this._config.isAnimated)
    }
}
const Ql = "focustrap",
    Zl = "bs.focustrap",
    Ie = `.${Zl}`,
    tu = `focusin${Ie}`,
    eu = `keydown.tab${Ie}`,
    nu = "Tab",
    su = "forward",
    Bs = "backward",
    ru = {
        autofocus: !0,
        trapElement: null
    },
    iu = {
        autofocus: "boolean",
        trapElement: "element"
    };
class yi extends ce {
    constructor(t) {
        super(), this._config = this._getConfig(t), this._isActive = !1, this._lastTabNavDirection = null
    }
    static get Default() {
        return ru
    }
    static get DefaultType() {
        return iu
    }
    static get NAME() {
        return Ql
    }
    activate() {
        this._isActive || (this._config.autofocus && this._config.trapElement.focus(), d.off(document, Ie), d.on(document, tu, t => this._handleFocusin(t)), d.on(document, eu, t => this._handleKeydown(t)), this._isActive = !0)
    }
    deactivate() {
        this._isActive && (this._isActive = !1, d.off(document, Ie))
    }
    _handleFocusin(t) {
        const {
            trapElement: n
        } = this._config;
        if (t.target === document || t.target === n || n.contains(t.target)) return;
        const s = v.focusableChildren(n);
        s.length === 0 ? n.focus() : this._lastTabNavDirection === Bs ? s[s.length - 1].focus() : s[0].focus()
    }
    _handleKeydown(t) {
        t.key === nu && (this._lastTabNavDirection = t.shiftKey ? Bs : su)
    }
}
const js = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",
    Us = ".sticky-top",
    be = "padding-right",
    Ws = "margin-right";
class Rn {
    constructor() {
        this._element = document.body
    }
    getWidth() {
        const t = document.documentElement.clientWidth;
        return Math.abs(window.innerWidth - t)
    }
    hide() {
        const t = this.getWidth();
        this._disableOverFlow(), this._setElementAttributes(this._element, be, n => n + t), this._setElementAttributes(js, be, n => n + t), this._setElementAttributes(Us, Ws, n => n - t)
    }
    reset() {
        this._resetElementAttributes(this._element, "overflow"), this._resetElementAttributes(this._element, be), this._resetElementAttributes(js, be), this._resetElementAttributes(Us, Ws)
    }
    isOverflowing() {
        return this.getWidth() > 0
    }
    _disableOverFlow() {
        this._saveInitialAttribute(this._element, "overflow"), this._element.style.overflow = "hidden"
    }
    _setElementAttributes(t, n, s) {
        const r = this.getWidth(),
            i = o => {
                if (o !== this._element && window.innerWidth > o.clientWidth + r) return;
                this._saveInitialAttribute(o, n);
                const a = window.getComputedStyle(o).getPropertyValue(n);
                o.style.setProperty(n, `${s(Number.parseFloat(a))}px`)
            };
        this._applyManipulationCallback(t, i)
    }
    _saveInitialAttribute(t, n) {
        const s = t.style.getPropertyValue(n);
        s && nt.setDataAttribute(t, n, s)
    }
    _resetElementAttributes(t, n) {
        const s = r => {
            const i = nt.getDataAttribute(r, n);
            if (i === null) {
                r.style.removeProperty(n);
                return
            }
            nt.removeDataAttribute(r, n), r.style.setProperty(n, i)
        };
        this._applyManipulationCallback(t, s)
    }
    _applyManipulationCallback(t, n) {
        if (et(t)) {
            n(t);
            return
        }
        for (const s of v.find(t, this._element)) n(s)
    }
}
const ou = "modal",
    au = "bs.modal",
    q = `.${au}`,
    cu = ".data-api",
    lu = "Escape",
    uu = `hide${q}`,
    fu = `hidePrevented${q}`,
    Ai = `hidden${q}`,
    Ti = `show${q}`,
    du = `shown${q}`,
    hu = `resize${q}`,
    pu = `click.dismiss${q}`,
    mu = `mousedown.dismiss${q}`,
    _u = `keydown.dismiss${q}`,
    gu = `click${q}${cu}`,
    Ks = "modal-open",
    Eu = "fade",
    qs = "show",
    ln = "modal-static",
    bu = ".modal.show",
    vu = ".modal-dialog",
    yu = ".modal-body",
    Au = '[data-bs-toggle="modal"]',
    Tu = {
        backdrop: !0,
        focus: !0,
        keyboard: !0
    },
    wu = {
        backdrop: "(boolean|string)",
        focus: "boolean",
        keyboard: "boolean"
    };
class Bt extends J {
    constructor(t, n) {
        super(t, n), this._dialog = v.findOne(vu, this._element), this._backdrop = this._initializeBackDrop(), this._focustrap = this._initializeFocusTrap(), this._isShown = !1, this._isTransitioning = !1, this._scrollBar = new Rn, this._addEventListeners()
    }
    static get Default() {
        return Tu
    }
    static get DefaultType() {
        return wu
    }
    static get NAME() {
        return ou
    }
    toggle(t) {
        return this._isShown ? this.hide() : this.show(t)
    }
    show(t) {
        this._isShown || this._isTransitioning || d.trigger(this._element, Ti, {
            relatedTarget: t
        }).defaultPrevented || (this._isShown = !0, this._isTransitioning = !0, this._scrollBar.hide(), document.body.classList.add(Ks), this._adjustDialog(), this._backdrop.show(() => this._showElement(t)))
    }
    hide() {
        !this._isShown || this._isTransitioning || d.trigger(this._element, uu).defaultPrevented || (this._isShown = !1, this._isTransitioning = !0, this._focustrap.deactivate(), this._element.classList.remove(qs), this._queueCallback(() => this._hideModal(), this._element, this._isAnimated()))
    }
    dispose() {
        d.off(window, q), d.off(this._dialog, q), this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose()
    }
    handleUpdate() {
        this._adjustDialog()
    }
    _initializeBackDrop() {
        return new vi({
            isVisible: !!this._config.backdrop,
            isAnimated: this._isAnimated()
        })
    }
    _initializeFocusTrap() {
        return new yi({
            trapElement: this._element
        })
    }
    _showElement(t) {
        document.body.contains(this._element) || document.body.append(this._element), this._element.style.display = "block", this._element.removeAttribute("aria-hidden"), this._element.setAttribute("aria-modal", !0), this._element.setAttribute("role", "dialog"), this._element.scrollTop = 0;
        const n = v.findOne(yu, this._dialog);
        n && (n.scrollTop = 0), ae(this._element), this._element.classList.add(qs);
        const s = () => {
            this._config.focus && this._focustrap.activate(), this._isTransitioning = !1, d.trigger(this._element, du, {
                relatedTarget: t
            })
        };
        this._queueCallback(s, this._dialog, this._isAnimated())
    }
    _addEventListeners() {
        d.on(this._element, _u, t => {
            if (t.key === lu) {
                if (this._config.keyboard) {
                    this.hide();
                    return
                }
                this._triggerBackdropTransition()
            }
        }), d.on(window, hu, () => {
            this._isShown && !this._isTransitioning && this._adjustDialog()
        }), d.on(this._element, mu, t => {
            d.one(this._element, pu, n => {
                if (!(this._element !== t.target || this._element !== n.target)) {
                    if (this._config.backdrop === "static") {
                        this._triggerBackdropTransition();
                        return
                    }
                    this._config.backdrop && this.hide()
                }
            })
        })
    }
    _hideModal() {
        this._element.style.display = "none", this._element.setAttribute("aria-hidden", !0), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._isTransitioning = !1, this._backdrop.hide(() => {
            document.body.classList.remove(Ks), this._resetAdjustments(), this._scrollBar.reset(), d.trigger(this._element, Ai)
        })
    }
    _isAnimated() {
        return this._element.classList.contains(Eu)
    }
    _triggerBackdropTransition() {
        if (d.trigger(this._element, fu).defaultPrevented) return;
        const n = this._element.scrollHeight > document.documentElement.clientHeight,
            s = this._element.style.overflowY;
        s === "hidden" || this._element.classList.contains(ln) || (n || (this._element.style.overflowY = "hidden"), this._element.classList.add(ln), this._queueCallback(() => {
            this._element.classList.remove(ln), this._queueCallback(() => {
                this._element.style.overflowY = s
            }, this._dialog)
        }, this._dialog), this._element.focus())
    }
    _adjustDialog() {
        const t = this._element.scrollHeight > document.documentElement.clientHeight,
            n = this._scrollBar.getWidth(),
            s = n > 0;
        if (s && !t) {
            const r = K() ? "paddingLeft" : "paddingRight";
            this._element.style[r] = `${n}px`
        }
        if (!s && t) {
            const r = K() ? "paddingRight" : "paddingLeft";
            this._element.style[r] = `${n}px`
        }
    }
    _resetAdjustments() {
        this._element.style.paddingLeft = "", this._element.style.paddingRight = ""
    }
    static jQueryInterface(t, n) {
        return this.each(function() {
            const s = Bt.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof s[t] > "u") throw new TypeError(`No method named "${t}"`);
                s[t](n)
            }
        })
    }
}
d.on(document, gu, Au, function(e) {
    const t = v.getElementFromSelector(this);
    ["A", "AREA"].includes(this.tagName) && e.preventDefault(), d.one(t, Ti, r => {
        r.defaultPrevented || d.one(t, Ai, () => {
            qt(this) && this.focus()
        })
    });
    const n = v.findOne(bu);
    n && Bt.getInstance(n).hide(), Bt.getOrCreateInstance(t).toggle(this)
});
je(Bt);
Y(Bt);
const Ou = "offcanvas",
    Su = "bs.offcanvas",
    rt = `.${Su}`,
    wi = ".data-api",
    Cu = `load${rt}${wi}`,
    Nu = "Escape",
    Ys = "show",
    zs = "showing",
    Gs = "hiding",
    Du = "offcanvas-backdrop",
    Oi = ".offcanvas.show",
    Lu = `show${rt}`,
    Ru = `shown${rt}`,
    $u = `hide${rt}`,
    Xs = `hidePrevented${rt}`,
    Si = `hidden${rt}`,
    Iu = `resize${rt}`,
    xu = `click${rt}${wi}`,
    Pu = `keydown.dismiss${rt}`,
    Mu = '[data-bs-toggle="offcanvas"]',
    ku = {
        backdrop: !0,
        keyboard: !0,
        scroll: !1
    },
    Vu = {
        backdrop: "(boolean|string)",
        keyboard: "boolean",
        scroll: "boolean"
    };
class ut extends J {
    constructor(t, n) {
        super(t, n), this._isShown = !1, this._backdrop = this._initializeBackDrop(), this._focustrap = this._initializeFocusTrap(), this._addEventListeners()
    }
    static get Default() {
        return ku
    }
    static get DefaultType() {
        return Vu
    }
    static get NAME() {
        return Ou
    }
    toggle(t) {
        return this._isShown ? this.hide() : this.show(t)
    }
    show(t) {
        if (this._isShown || d.trigger(this._element, Lu, {
                relatedTarget: t
            }).defaultPrevented) return;
        this._isShown = !0, this._backdrop.show(), this._config.scroll || new Rn().hide(), this._element.setAttribute("aria-modal", !0), this._element.setAttribute("role", "dialog"), this._element.classList.add(zs);
        const s = () => {
            (!this._config.scroll || this._config.backdrop) && this._focustrap.activate(), this._element.classList.add(Ys), this._element.classList.remove(zs), d.trigger(this._element, Ru, {
                relatedTarget: t
            })
        };
        this._queueCallback(s, this._element, !0)
    }
    hide() {
        if (!this._isShown || d.trigger(this._element, $u).defaultPrevented) return;
        this._focustrap.deactivate(), this._element.blur(), this._isShown = !1, this._element.classList.add(Gs), this._backdrop.hide();
        const n = () => {
            this._element.classList.remove(Ys, Gs), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._config.scroll || new Rn().reset(), d.trigger(this._element, Si)
        };
        this._queueCallback(n, this._element, !0)
    }
    dispose() {
        this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose()
    }
    _initializeBackDrop() {
        const t = () => {
                if (this._config.backdrop === "static") {
                    d.trigger(this._element, Xs);
                    return
                }
                this.hide()
            },
            n = !!this._config.backdrop;
        return new vi({
            className: Du,
            isVisible: n,
            isAnimated: !0,
            rootElement: this._element.parentNode,
            clickCallback: n ? t : null
        })
    }
    _initializeFocusTrap() {
        return new yi({
            trapElement: this._element
        })
    }
    _addEventListeners() {
        d.on(this._element, Pu, t => {
            if (t.key === Nu) {
                if (this._config.keyboard) {
                    this.hide();
                    return
                }
                d.trigger(this._element, Xs)
            }
        })
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = ut.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor") throw new TypeError(`No method named "${t}"`);
                n[t](this)
            }
        })
    }
}
d.on(document, xu, Mu, function(e) {
    const t = v.getElementFromSelector(this);
    if (["A", "AREA"].includes(this.tagName) && e.preventDefault(), lt(this)) return;
    d.one(t, Si, () => {
        qt(this) && this.focus()
    });
    const n = v.findOne(Oi);
    n && n !== t && ut.getInstance(n).hide(), ut.getOrCreateInstance(t).toggle(this)
});
d.on(window, Cu, () => {
    for (const e of v.find(Oi)) ut.getOrCreateInstance(e).show()
});
d.on(window, Iu, () => {
    for (const e of v.find("[aria-modal][class*=show][class*=offcanvas-]")) getComputedStyle(e).position !== "fixed" && ut.getOrCreateInstance(e).hide()
});
je(ut);
Y(ut);
const Fu = /^aria-[\w-]*$/i,
    Ci = {
        "*": ["class", "dir", "id", "lang", "role", Fu],
        a: ["target", "href", "title", "rel"],
        area: [],
        b: [],
        br: [],
        col: [],
        code: [],
        dd: [],
        div: [],
        dl: [],
        dt: [],
        em: [],
        hr: [],
        h1: [],
        h2: [],
        h3: [],
        h4: [],
        h5: [],
        h6: [],
        i: [],
        img: ["src", "srcset", "alt", "title", "width", "height"],
        li: [],
        ol: [],
        p: [],
        pre: [],
        s: [],
        small: [],
        span: [],
        sub: [],
        sup: [],
        strong: [],
        u: [],
        ul: []
    },
    Hu = new Set(["background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href"]),
    Bu = /^(?!javascript:)(?:[a-z0-9+.-]+:|[^&:/?#]*(?:[/?#]|$))/i,
    ju = (e, t) => {
        const n = e.nodeName.toLowerCase();
        return t.includes(n) ? Hu.has(n) ? !!Bu.test(e.nodeValue) : !0 : t.filter(s => s instanceof RegExp).some(s => s.test(n))
    };

function Uu(e, t, n) {
    if (!e.length) return e;
    if (n && typeof n == "function") return n(e);
    const r = new window.DOMParser().parseFromString(e, "text/html"),
        i = [].concat(...r.body.querySelectorAll("*"));
    for (const o of i) {
        const a = o.nodeName.toLowerCase();
        if (!Object.keys(t).includes(a)) {
            o.remove();
            continue
        }
        const l = [].concat(...o.attributes),
            u = [].concat(t["*"] || [], t[a] || []);
        for (const c of l) ju(c, u) || o.removeAttribute(c.nodeName)
    }
    return r.body.innerHTML
}
const Wu = "TemplateFactory",
    Ku = {
        allowList: Ci,
        content: {},
        extraClass: "",
        html: !1,
        sanitize: !0,
        sanitizeFn: null,
        template: "<div></div>"
    },
    qu = {
        allowList: "object",
        content: "object",
        extraClass: "(string|function)",
        html: "boolean",
        sanitize: "boolean",
        sanitizeFn: "(null|function)",
        template: "string"
    },
    Yu = {
        entry: "(string|element|function|null)",
        selector: "(string|element)"
    };
class zu extends ce {
    constructor(t) {
        super(), this._config = this._getConfig(t)
    }
    static get Default() {
        return Ku
    }
    static get DefaultType() {
        return qu
    }
    static get NAME() {
        return Wu
    }
    getContent() {
        return Object.values(this._config.content).map(t => this._resolvePossibleFunction(t)).filter(Boolean)
    }
    hasContent() {
        return this.getContent().length > 0
    }
    changeContent(t) {
        return this._checkContent(t), this._config.content = {
            ...this._config.content,
            ...t
        }, this
    }
    toHtml() {
        const t = document.createElement("div");
        t.innerHTML = this._maybeSanitize(this._config.template);
        for (const [r, i] of Object.entries(this._config.content)) this._setContent(t, i, r);
        const n = t.children[0],
            s = this._resolvePossibleFunction(this._config.extraClass);
        return s && n.classList.add(...s.split(" ")), n
    }
    _typeCheckConfig(t) {
        super._typeCheckConfig(t), this._checkContent(t.content)
    }
    _checkContent(t) {
        for (const [n, s] of Object.entries(t)) super._typeCheckConfig({
            selector: n,
            entry: s
        }, Yu)
    }
    _setContent(t, n, s) {
        const r = v.findOne(s, t);
        if (r) {
            if (n = this._resolvePossibleFunction(n), !n) {
                r.remove();
                return
            }
            if (et(n)) {
                this._putElementInTemplate(ct(n), r);
                return
            }
            if (this._config.html) {
                r.innerHTML = this._maybeSanitize(n);
                return
            }
            r.textContent = n
        }
    }
    _maybeSanitize(t) {
        return this._config.sanitize ? Uu(t, this._config.allowList, this._config.sanitizeFn) : t
    }
    _resolvePossibleFunction(t) {
        return M(t, [this])
    }
    _putElementInTemplate(t, n) {
        if (this._config.html) {
            n.innerHTML = "", n.append(t);
            return
        }
        n.textContent = t.textContent
    }
}
const Gu = "tooltip",
    Xu = new Set(["sanitize", "allowList", "sanitizeFn"]),
    un = "fade",
    Ju = "modal",
    ve = "show",
    Qu = ".tooltip-inner",
    Js = `.${Ju}`,
    Qs = "hide.bs.modal",
    Zt = "hover",
    fn = "focus",
    Zu = "click",
    tf = "manual",
    ef = "hide",
    nf = "hidden",
    sf = "show",
    rf = "shown",
    of = "inserted",
    af = "click",
    cf = "focusin",
    lf = "focusout",
    uf = "mouseenter",
    ff = "mouseleave",
    df = {
        AUTO: "auto",
        TOP: "top",
        RIGHT: K() ? "left" : "right",
        BOTTOM: "bottom",
        LEFT: K() ? "right" : "left"
    },
    hf = {
        allowList: Ci,
        animation: !0,
        boundary: "clippingParents",
        container: !1,
        customClass: "",
        delay: 0,
        fallbackPlacements: ["top", "right", "bottom", "left"],
        html: !1,
        offset: [0, 6],
        placement: "top",
        popperConfig: null,
        sanitize: !0,
        sanitizeFn: null,
        selector: !1,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        title: "",
        trigger: "hover focus"
    },
    pf = {
        allowList: "object",
        animation: "boolean",
        boundary: "(string|element)",
        container: "(string|element|boolean)",
        customClass: "(string|function)",
        delay: "(number|object)",
        fallbackPlacements: "array",
        html: "boolean",
        offset: "(array|string|function)",
        placement: "(string|function)",
        popperConfig: "(null|object|function)",
        sanitize: "boolean",
        sanitizeFn: "(null|function)",
        selector: "(string|boolean)",
        template: "string",
        title: "(string|element|function)",
        trigger: "string"
    };
class zt extends J {
    constructor(t, n) {
        if (typeof ti > "u") throw new TypeError("Bootstrap's tooltips require Popper (https://popper.js.org)");
        super(t, n), this._isEnabled = !0, this._timeout = 0, this._isHovered = null, this._activeTrigger = {}, this._popper = null, this._templateFactory = null, this._newContent = null, this.tip = null, this._setListeners(), this._config.selector || this._fixTitle()
    }
    static get Default() {
        return hf
    }
    static get DefaultType() {
        return pf
    }
    static get NAME() {
        return Gu
    }
    enable() {
        this._isEnabled = !0
    }
    disable() {
        this._isEnabled = !1
    }
    toggleEnabled() {
        this._isEnabled = !this._isEnabled
    }
    toggle() {
        if (this._isEnabled) {
            if (this._activeTrigger.click = !this._activeTrigger.click, this._isShown()) {
                this._leave();
                return
            }
            this._enter()
        }
    }
    dispose() {
        clearTimeout(this._timeout), d.off(this._element.closest(Js), Qs, this._hideModalHandler), this._element.getAttribute("data-bs-original-title") && this._element.setAttribute("title", this._element.getAttribute("data-bs-original-title")), this._disposePopper(), super.dispose()
    }
    show() {
        if (this._element.style.display === "none") throw new Error("Please use show on visible elements");
        if (!(this._isWithContent() && this._isEnabled)) return;
        const t = d.trigger(this._element, this.constructor.eventName(sf)),
            s = (si(this._element) || this._element.ownerDocument.documentElement).contains(this._element);
        if (t.defaultPrevented || !s) return;
        this._disposePopper();
        const r = this._getTipElement();
        this._element.setAttribute("aria-describedby", r.getAttribute("id"));
        const {
            container: i
        } = this._config;
        if (this._element.ownerDocument.documentElement.contains(this.tip) || (i.append(r), d.trigger(this._element, this.constructor.eventName(of))), this._popper = this._createPopper(r), r.classList.add(ve), "ontouchstart" in document.documentElement)
            for (const a of [].concat(...document.body.children)) d.on(a, "mouseover", Re);
        const o = () => {
            d.trigger(this._element, this.constructor.eventName(rf)), this._isHovered === !1 && this._leave(), this._isHovered = !1
        };
        this._queueCallback(o, this.tip, this._isAnimated())
    }
    hide() {
        if (!this._isShown() || d.trigger(this._element, this.constructor.eventName(ef)).defaultPrevented) return;
        if (this._getTipElement().classList.remove(ve), "ontouchstart" in document.documentElement)
            for (const r of [].concat(...document.body.children)) d.off(r, "mouseover", Re);
        this._activeTrigger[Zu] = !1, this._activeTrigger[fn] = !1, this._activeTrigger[Zt] = !1, this._isHovered = null;
        const s = () => {
            this._isWithActiveTrigger() || (this._isHovered || this._disposePopper(), this._element.removeAttribute("aria-describedby"), d.trigger(this._element, this.constructor.eventName(nf)))
        };
        this._queueCallback(s, this.tip, this._isAnimated())
    }
    update() {
        this._popper && this._popper.update()
    }
    _isWithContent() {
        return !!this._getTitle()
    }
    _getTipElement() {
        return this.tip || (this.tip = this._createTipElement(this._newContent || this._getContentForTemplate())), this.tip
    }
    _createTipElement(t) {
        const n = this._getTemplateFactory(t).toHtml();
        if (!n) return null;
        n.classList.remove(un, ve), n.classList.add(`bs-${this.constructor.NAME}-auto`);
        const s = Za(this.constructor.NAME).toString();
        return n.setAttribute("id", s), this._isAnimated() && n.classList.add(un), n
    }
    setContent(t) {
        this._newContent = t, this._isShown() && (this._disposePopper(), this.show())
    }
    _getTemplateFactory(t) {
        return this._templateFactory ? this._templateFactory.changeContent(t) : this._templateFactory = new zu({
            ...this._config,
            content: t,
            extraClass: this._resolvePossibleFunction(this._config.customClass)
        }), this._templateFactory
    }
    _getContentForTemplate() {
        return {
            [Qu]: this._getTitle()
        }
    }
    _getTitle() {
        return this._resolvePossibleFunction(this._config.title) || this._element.getAttribute("data-bs-original-title")
    }
    _initializeOnDelegatedTarget(t) {
        return this.constructor.getOrCreateInstance(t.delegateTarget, this._getDelegateConfig())
    }
    _isAnimated() {
        return this._config.animation || this.tip && this.tip.classList.contains(un)
    }
    _isShown() {
        return this.tip && this.tip.classList.contains(ve)
    }
    _createPopper(t) {
        const n = M(this._config.placement, [this, t, this._element]),
            s = df[n.toUpperCase()];
        return Gn(this._element, t, this._getPopperConfig(s))
    }
    _getOffset() {
        const {
            offset: t
        } = this._config;
        return typeof t == "string" ? t.split(",").map(n => Number.parseInt(n, 10)) : typeof t == "function" ? n => t(n, this._element) : t
    }
    _resolvePossibleFunction(t) {
        return M(t, [this._element])
    }
    _getPopperConfig(t) {
        const n = {
            placement: t,
            modifiers: [{
                name: "flip",
                options: {
                    fallbackPlacements: this._config.fallbackPlacements
                }
            }, {
                name: "offset",
                options: {
                    offset: this._getOffset()
                }
            }, {
                name: "preventOverflow",
                options: {
                    boundary: this._config.boundary
                }
            }, {
                name: "arrow",
                options: {
                    element: `.${this.constructor.NAME}-arrow`
                }
            }, {
                name: "preSetPlacement",
                enabled: !0,
                phase: "beforeMain",
                fn: s => {
                    this._getTipElement().setAttribute("data-popper-placement", s.state.placement)
                }
            }]
        };
        return {
            ...n,
            ...M(this._config.popperConfig, [n])
        }
    }
    _setListeners() {
        const t = this._config.trigger.split(" ");
        for (const n of t)
            if (n === "click") d.on(this._element, this.constructor.eventName(af), this._config.selector, s => {
                this._initializeOnDelegatedTarget(s).toggle()
            });
            else if (n !== tf) {
            const s = n === Zt ? this.constructor.eventName(uf) : this.constructor.eventName(cf),
                r = n === Zt ? this.constructor.eventName(ff) : this.constructor.eventName(lf);
            d.on(this._element, s, this._config.selector, i => {
                const o = this._initializeOnDelegatedTarget(i);
                o._activeTrigger[i.type === "focusin" ? fn : Zt] = !0, o._enter()
            }), d.on(this._element, r, this._config.selector, i => {
                const o = this._initializeOnDelegatedTarget(i);
                o._activeTrigger[i.type === "focusout" ? fn : Zt] = o._element.contains(i.relatedTarget), o._leave()
            })
        }
        this._hideModalHandler = () => {
            this._element && this.hide()
        }, d.on(this._element.closest(Js), Qs, this._hideModalHandler)
    }
    _fixTitle() {
        const t = this._element.getAttribute("title");
        t && (!this._element.getAttribute("aria-label") && !this._element.textContent.trim() && this._element.setAttribute("aria-label", t), this._element.setAttribute("data-bs-original-title", t), this._element.removeAttribute("title"))
    }
    _enter() {
        if (this._isShown() || this._isHovered) {
            this._isHovered = !0;
            return
        }
        this._isHovered = !0, this._setTimeout(() => {
            this._isHovered && this.show()
        }, this._config.delay.show)
    }
    _leave() {
        this._isWithActiveTrigger() || (this._isHovered = !1, this._setTimeout(() => {
            this._isHovered || this.hide()
        }, this._config.delay.hide))
    }
    _setTimeout(t, n) {
        clearTimeout(this._timeout), this._timeout = setTimeout(t, n)
    }
    _isWithActiveTrigger() {
        return Object.values(this._activeTrigger).includes(!0)
    }
    _getConfig(t) {
        const n = nt.getDataAttributes(this._element);
        for (const s of Object.keys(n)) Xu.has(s) && delete n[s];
        return t = {
            ...n,
            ...typeof t == "object" && t ? t : {}
        }, t = this._mergeConfigObj(t), t = this._configAfterMerge(t), this._typeCheckConfig(t), t
    }
    _configAfterMerge(t) {
        return t.container = t.container === !1 ? document.body : ct(t.container), typeof t.delay == "number" && (t.delay = {
            show: t.delay,
            hide: t.delay
        }), typeof t.title == "number" && (t.title = t.title.toString()), typeof t.content == "number" && (t.content = t.content.toString()), t
    }
    _getDelegateConfig() {
        const t = {};
        for (const [n, s] of Object.entries(this._config)) this.constructor.Default[n] !== s && (t[n] = s);
        return t.selector = !1, t.trigger = "manual", t
    }
    _disposePopper() {
        this._popper && (this._popper.destroy(), this._popper = null), this.tip && (this.tip.remove(), this.tip = null)
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = zt.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof n[t] > "u") throw new TypeError(`No method named "${t}"`);
                n[t]()
            }
        })
    }
}
Y(zt);
const mf = "popover",
    _f = ".popover-header",
    gf = ".popover-body",
    Ef = {
        ...zt.Default,
        content: "",
        offset: [0, 8],
        placement: "right",
        template: '<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
        trigger: "click"
    },
    bf = {
        ...zt.DefaultType,
        content: "(null|string|element|function)"
    };
class Zn extends zt {
    static get Default() {
        return Ef
    }
    static get DefaultType() {
        return bf
    }
    static get NAME() {
        return mf
    }
    _isWithContent() {
        return this._getTitle() || this._getContent()
    }
    _getContentForTemplate() {
        return {
            [_f]: this._getTitle(),
            [gf]: this._getContent()
        }
    }
    _getContent() {
        return this._resolvePossibleFunction(this._config.content)
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = Zn.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof n[t] > "u") throw new TypeError(`No method named "${t}"`);
                n[t]()
            }
        })
    }
}
Y(Zn);
const vf = "scrollspy",
    yf = "bs.scrollspy",
    ts = `.${yf}`,
    Af = ".data-api",
    Tf = `activate${ts}`,
    Zs = `click${ts}`,
    wf = `load${ts}${Af}`,
    Of = "dropdown-item",
    Rt = "active",
    Sf = '[data-bs-spy="scroll"]',
    dn = "[href]",
    Cf = ".nav, .list-group",
    tr = ".nav-link",
    Nf = ".nav-item",
    Df = ".list-group-item",
    Lf = `${tr}, ${Nf} > ${tr}, ${Df}`,
    Rf = ".dropdown",
    $f = ".dropdown-toggle",
    If = {
        offset: null,
        rootMargin: "0px 0px -25%",
        smoothScroll: !1,
        target: null,
        threshold: [.1, .5, 1]
    },
    xf = {
        offset: "(number|null)",
        rootMargin: "string",
        smoothScroll: "boolean",
        target: "element",
        threshold: "array"
    };
class Ke extends J {
    constructor(t, n) {
        super(t, n), this._targetLinks = new Map, this._observableSections = new Map, this._rootElement = getComputedStyle(this._element).overflowY === "visible" ? null : this._element, this._activeTarget = null, this._observer = null, this._previousScrollData = {
            visibleEntryTop: 0,
            parentScrollTop: 0
        }, this.refresh()
    }
    static get Default() {
        return If
    }
    static get DefaultType() {
        return xf
    }
    static get NAME() {
        return vf
    }
    refresh() {
        this._initializeTargetsAndObservables(), this._maybeEnableSmoothScroll(), this._observer ? this._observer.disconnect() : this._observer = this._getNewObserver();
        for (const t of this._observableSections.values()) this._observer.observe(t)
    }
    dispose() {
        this._observer.disconnect(), super.dispose()
    }
    _configAfterMerge(t) {
        return t.target = ct(t.target) || document.body, t.rootMargin = t.offset ? `${t.offset}px 0px -30%` : t.rootMargin, typeof t.threshold == "string" && (t.threshold = t.threshold.split(",").map(n => Number.parseFloat(n))), t
    }
    _maybeEnableSmoothScroll() {
        this._config.smoothScroll && (d.off(this._config.target, Zs), d.on(this._config.target, Zs, dn, t => {
            const n = this._observableSections.get(t.target.hash);
            if (n) {
                t.preventDefault();
                const s = this._rootElement || window,
                    r = n.offsetTop - this._element.offsetTop;
                if (s.scrollTo) {
                    s.scrollTo({
                        top: r,
                        behavior: "smooth"
                    });
                    return
                }
                s.scrollTop = r
            }
        }))
    }
    _getNewObserver() {
        const t = {
            root: this._rootElement,
            threshold: this._config.threshold,
            rootMargin: this._config.rootMargin
        };
        return new IntersectionObserver(n => this._observerCallback(n), t)
    }
    _observerCallback(t) {
        const n = o => this._targetLinks.get(`#${o.target.id}`),
            s = o => {
                this._previousScrollData.visibleEntryTop = o.target.offsetTop, this._process(n(o))
            },
            r = (this._rootElement || document.documentElement).scrollTop,
            i = r >= this._previousScrollData.parentScrollTop;
        this._previousScrollData.parentScrollTop = r;
        for (const o of t) {
            if (!o.isIntersecting) {
                this._activeTarget = null, this._clearActiveClass(n(o));
                continue
            }
            const a = o.target.offsetTop >= this._previousScrollData.visibleEntryTop;
            if (i && a) {
                if (s(o), !r) return;
                continue
            }!i && !a && s(o)
        }
    }
    _initializeTargetsAndObservables() {
        this._targetLinks = new Map, this._observableSections = new Map;
        const t = v.find(dn, this._config.target);
        for (const n of t) {
            if (!n.hash || lt(n)) continue;
            const s = v.findOne(decodeURI(n.hash), this._element);
            qt(s) && (this._targetLinks.set(decodeURI(n.hash), n), this._observableSections.set(n.hash, s))
        }
    }
    _process(t) {
        this._activeTarget !== t && (this._clearActiveClass(this._config.target), this._activeTarget = t, t.classList.add(Rt), this._activateParents(t), d.trigger(this._element, Tf, {
            relatedTarget: t
        }))
    }
    _activateParents(t) {
        if (t.classList.contains(Of)) {
            v.findOne($f, t.closest(Rf)).classList.add(Rt);
            return
        }
        for (const n of v.parents(t, Cf))
            for (const s of v.prev(n, Lf)) s.classList.add(Rt)
    }
    _clearActiveClass(t) {
        t.classList.remove(Rt);
        const n = v.find(`${dn}.${Rt}`, t);
        for (const s of n) s.classList.remove(Rt)
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = Ke.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor") throw new TypeError(`No method named "${t}"`);
                n[t]()
            }
        })
    }
}
d.on(window, wf, () => {
    for (const e of v.find(Sf)) Ke.getOrCreateInstance(e)
});
Y(Ke);
const Pf = "tab",
    Mf = "bs.tab",
    Nt = `.${Mf}`,
    kf = `hide${Nt}`,
    Vf = `hidden${Nt}`,
    Ff = `show${Nt}`,
    Hf = `shown${Nt}`,
    Bf = `click${Nt}`,
    jf = `keydown${Nt}`,
    Uf = `load${Nt}`,
    Wf = "ArrowLeft",
    er = "ArrowRight",
    Kf = "ArrowUp",
    nr = "ArrowDown",
    hn = "Home",
    sr = "End",
    yt = "active",
    rr = "fade",
    pn = "show",
    qf = "dropdown",
    Ni = ".dropdown-toggle",
    Yf = ".dropdown-menu",
    mn = `:not(${Ni})`,
    zf = '.list-group, .nav, [role="tablist"]',
    Gf = ".nav-item, .list-group-item",
    Xf = `.nav-link${mn}, .list-group-item${mn}, [role="tab"]${mn}`,
    Di = '[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]',
    _n = `${Xf}, ${Di}`,
    Jf = `.${yt}[data-bs-toggle="tab"], .${yt}[data-bs-toggle="pill"], .${yt}[data-bs-toggle="list"]`;
class jt extends J {
    constructor(t) {
        super(t), this._parent = this._element.closest(zf), this._parent && (this._setInitialAttributes(this._parent, this._getChildren()), d.on(this._element, jf, n => this._keydown(n)))
    }
    static get NAME() {
        return Pf
    }
    show() {
        const t = this._element;
        if (this._elemIsActive(t)) return;
        const n = this._getActiveElem(),
            s = n ? d.trigger(n, kf, {
                relatedTarget: t
            }) : null;
        d.trigger(t, Ff, {
            relatedTarget: n
        }).defaultPrevented || s && s.defaultPrevented || (this._deactivate(n, t), this._activate(t, n))
    }
    _activate(t, n) {
        if (!t) return;
        t.classList.add(yt), this._activate(v.getElementFromSelector(t));
        const s = () => {
            if (t.getAttribute("role") !== "tab") {
                t.classList.add(pn);
                return
            }
            t.removeAttribute("tabindex"), t.setAttribute("aria-selected", !0), this._toggleDropDown(t, !0), d.trigger(t, Hf, {
                relatedTarget: n
            })
        };
        this._queueCallback(s, t, t.classList.contains(rr))
    }
    _deactivate(t, n) {
        if (!t) return;
        t.classList.remove(yt), t.blur(), this._deactivate(v.getElementFromSelector(t));
        const s = () => {
            if (t.getAttribute("role") !== "tab") {
                t.classList.remove(pn);
                return
            }
            t.setAttribute("aria-selected", !1), t.setAttribute("tabindex", "-1"), this._toggleDropDown(t, !1), d.trigger(t, Vf, {
                relatedTarget: n
            })
        };
        this._queueCallback(s, t, t.classList.contains(rr))
    }
    _keydown(t) {
        if (![Wf, er, Kf, nr, hn, sr].includes(t.key)) return;
        t.stopPropagation(), t.preventDefault();
        const n = this._getChildren().filter(r => !lt(r));
        let s;
        if ([hn, sr].includes(t.key)) s = n[t.key === hn ? 0 : n.length - 1];
        else {
            const r = [er, nr].includes(t.key);
            s = Xn(n, t.target, r, !0)
        }
        s && (s.focus({
            preventScroll: !0
        }), jt.getOrCreateInstance(s).show())
    }
    _getChildren() {
        return v.find(_n, this._parent)
    }
    _getActiveElem() {
        return this._getChildren().find(t => this._elemIsActive(t)) || null
    }
    _setInitialAttributes(t, n) {
        this._setAttributeIfNotExists(t, "role", "tablist");
        for (const s of n) this._setInitialAttributesOnChild(s)
    }
    _setInitialAttributesOnChild(t) {
        t = this._getInnerElement(t);
        const n = this._elemIsActive(t),
            s = this._getOuterElement(t);
        t.setAttribute("aria-selected", n), s !== t && this._setAttributeIfNotExists(s, "role", "presentation"), n || t.setAttribute("tabindex", "-1"), this._setAttributeIfNotExists(t, "role", "tab"), this._setInitialAttributesOnTargetPanel(t)
    }
    _setInitialAttributesOnTargetPanel(t) {
        const n = v.getElementFromSelector(t);
        n && (this._setAttributeIfNotExists(n, "role", "tabpanel"), t.id && this._setAttributeIfNotExists(n, "aria-labelledby", `${t.id}`))
    }
    _toggleDropDown(t, n) {
        const s = this._getOuterElement(t);
        if (!s.classList.contains(qf)) return;
        const r = (i, o) => {
            const a = v.findOne(i, s);
            a && a.classList.toggle(o, n)
        };
        r(Ni, yt), r(Yf, pn), s.setAttribute("aria-expanded", n)
    }
    _setAttributeIfNotExists(t, n, s) {
        t.hasAttribute(n) || t.setAttribute(n, s)
    }
    _elemIsActive(t) {
        return t.classList.contains(yt)
    }
    _getInnerElement(t) {
        return t.matches(_n) ? t : v.findOne(_n, t)
    }
    _getOuterElement(t) {
        return t.closest(Gf) || t
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = jt.getOrCreateInstance(this);
            if (typeof t == "string") {
                if (n[t] === void 0 || t.startsWith("_") || t === "constructor") throw new TypeError(`No method named "${t}"`);
                n[t]()
            }
        })
    }
}
d.on(document, Bf, Di, function(e) {
    ["A", "AREA"].includes(this.tagName) && e.preventDefault(), !lt(this) && jt.getOrCreateInstance(this).show()
});
d.on(window, Uf, () => {
    for (const e of v.find(Jf)) jt.getOrCreateInstance(e)
});
Y(jt);
const Qf = "toast",
    Zf = "bs.toast",
    ht = `.${Zf}`,
    td = `mouseover${ht}`,
    ed = `mouseout${ht}`,
    nd = `focusin${ht}`,
    sd = `focusout${ht}`,
    rd = `hide${ht}`,
    id = `hidden${ht}`,
    od = `show${ht}`,
    ad = `shown${ht}`,
    cd = "fade",
    ir = "hide",
    ye = "show",
    Ae = "showing",
    ld = {
        animation: "boolean",
        autohide: "boolean",
        delay: "number"
    },
    ud = {
        animation: !0,
        autohide: !0,
        delay: 5e3
    };
class qe extends J {
    constructor(t, n) {
        super(t, n), this._timeout = null, this._hasMouseInteraction = !1, this._hasKeyboardInteraction = !1, this._setListeners()
    }
    static get Default() {
        return ud
    }
    static get DefaultType() {
        return ld
    }
    static get NAME() {
        return Qf
    }
    show() {
        if (d.trigger(this._element, od).defaultPrevented) return;
        this._clearTimeout(), this._config.animation && this._element.classList.add(cd);
        const n = () => {
            this._element.classList.remove(Ae), d.trigger(this._element, ad), this._maybeScheduleHide()
        };
        this._element.classList.remove(ir), ae(this._element), this._element.classList.add(ye, Ae), this._queueCallback(n, this._element, this._config.animation)
    }
    hide() {
        if (!this.isShown() || d.trigger(this._element, rd).defaultPrevented) return;
        const n = () => {
            this._element.classList.add(ir), this._element.classList.remove(Ae, ye), d.trigger(this._element, id)
        };
        this._element.classList.add(Ae), this._queueCallback(n, this._element, this._config.animation)
    }
    dispose() {
        this._clearTimeout(), this.isShown() && this._element.classList.remove(ye), super.dispose()
    }
    isShown() {
        return this._element.classList.contains(ye)
    }
    _maybeScheduleHide() {
        this._config.autohide && (this._hasMouseInteraction || this._hasKeyboardInteraction || (this._timeout = setTimeout(() => {
            this.hide()
        }, this._config.delay)))
    }
    _onInteraction(t, n) {
        switch (t.type) {
            case "mouseover":
            case "mouseout": {
                this._hasMouseInteraction = n;
                break
            }
            case "focusin":
            case "focusout": {
                this._hasKeyboardInteraction = n;
                break
            }
        }
        if (n) {
            this._clearTimeout();
            return
        }
        const s = t.relatedTarget;
        this._element === s || this._element.contains(s) || this._maybeScheduleHide()
    }
    _setListeners() {
        d.on(this._element, td, t => this._onInteraction(t, !0)), d.on(this._element, ed, t => this._onInteraction(t, !1)), d.on(this._element, nd, t => this._onInteraction(t, !0)), d.on(this._element, sd, t => this._onInteraction(t, !1))
    }
    _clearTimeout() {
        clearTimeout(this._timeout), this._timeout = null
    }
    static jQueryInterface(t) {
        return this.each(function() {
            const n = qe.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof n[t] > "u") throw new TypeError(`No method named "${t}"`);
                n[t](this)
            }
        })
    }
}
je(qe);
Y(qe);
export {
    Bt as M, R as a
};