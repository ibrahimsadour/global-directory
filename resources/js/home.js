import './bootstrap.js';

var Te = !1,
    Ie = !1,
    N = [],
    $e = -1;

function qn(e) {
    Wn(e)
}

function Wn(e) {
    N.includes(e) || N.push(e), Un()
}

function Ct(e) {
    let t = N.indexOf(e);
    t !== -1 && t > $e && N.splice(t, 1)
}

function Un() {
    !Ie && !Te && (Te = !0, queueMicrotask(Jn))
}

function Jn() {
    Te = !1, Ie = !0;
    for (let e = 0; e < N.length; e++) N[e](), $e = e;
    N.length = 0, $e = -1, Ie = !1
}
var q, k, W, Mt, Pe = !0;

function Vn(e) {
    Pe = !1, e(), Pe = !0
}

function Yn(e) {
    q = e.reactive, W = e.release, k = t => e.effect(t, {
        scheduler: n => {
            Pe ? qn(n) : n()
        }
    }), Mt = e.raw
}

function pt(e) {
    k = e
}

function Gn(e) {
    let t = () => {};
    return [r => {
        let i = k(r);
        return e._x_effects || (e._x_effects = new Set, e._x_runEffects = () => {
            e._x_effects.forEach(o => o())
        }), e._x_effects.add(i), t = () => {
            i !== void 0 && (e._x_effects.delete(i), W(i))
        }, i
    }, () => {
        t()
    }]
}

function Tt(e, t) {
    let n = !0,
        r, i = k(() => {
            let o = e();
            JSON.stringify(o), n ? r = o : queueMicrotask(() => {
                t(o, r), r = o
            }), n = !1
        });
    return () => W(i)
}
var It = [],
    $t = [],
    Pt = [];

function Xn(e) {
    Pt.push(e)
}

function Ue(e, t) {
    typeof t == "function" ? (e._x_cleanups || (e._x_cleanups = []), e._x_cleanups.push(t)) : (t = e, $t.push(t))
}

function Rt(e) {
    It.push(e)
}

function jt(e, t, n) {
    e._x_attributeCleanups || (e._x_attributeCleanups = {}), e._x_attributeCleanups[t] || (e._x_attributeCleanups[t] = []), e._x_attributeCleanups[t].push(n)
}

function Lt(e, t) {
    e._x_attributeCleanups && Object.entries(e._x_attributeCleanups).forEach(([n, r]) => {
        (t === void 0 || t.includes(n)) && (r.forEach(i => i()), delete e._x_attributeCleanups[n])
    })
}

function Zn(e) {
    if (e._x_cleanups)
        for (; e._x_cleanups.length;) e._x_cleanups.pop()()
}
var Je = new MutationObserver(Xe),
    Ve = !1;

function Ye() {
    Je.observe(document, {
        subtree: !0,
        childList: !0,
        attributes: !0,
        attributeOldValue: !0
    }), Ve = !0
}

function Nt() {
    Qn(), Je.disconnect(), Ve = !1
}
var V = [];

function Qn() {
    let e = Je.takeRecords();
    V.push(() => e.length > 0 && Xe(e));
    let t = V.length;
    queueMicrotask(() => {
        if (V.length === t)
            for (; V.length > 0;) V.shift()()
    })
}

function y(e) {
    if (!Ve) return e();
    Nt();
    let t = e();
    return Ye(), t
}
var Ge = !1,
    pe = [];

function er() {
    Ge = !0
}

function tr() {
    Ge = !1, Xe(pe), pe = []
}

function Xe(e) {
    if (Ge) {
        pe = pe.concat(e);
        return
    }
    let t = new Set,
        n = new Set,
        r = new Map,
        i = new Map;
    for (let o = 0; o < e.length; o++)
        if (!e[o].target._x_ignoreMutationObserver && (e[o].type === "childList" && (e[o].addedNodes.forEach(s => s.nodeType === 1 && t.add(s)), e[o].removedNodes.forEach(s => s.nodeType === 1 && n.add(s))), e[o].type === "attributes")) {
            let s = e[o].target,
                a = e[o].attributeName,
                u = e[o].oldValue,
                c = () => {
                    r.has(s) || r.set(s, []), r.get(s).push({
                        name: a,
                        value: s.getAttribute(a)
                    })
                },
                l = () => {
                    i.has(s) || i.set(s, []), i.get(s).push(a)
                };
            s.hasAttribute(a) && u === null ? c() : s.hasAttribute(a) ? (l(), c()) : l()
        } i.forEach((o, s) => {
        Lt(s, o)
    }), r.forEach((o, s) => {
        It.forEach(a => a(s, o))
    });
    for (let o of n) t.has(o) || $t.forEach(s => s(o));
    t.forEach(o => {
        o._x_ignoreSelf = !0, o._x_ignore = !0
    });
    for (let o of t) n.has(o) || o.isConnected && (delete o._x_ignoreSelf, delete o._x_ignore, Pt.forEach(s => s(o)), o._x_ignore = !0, o._x_ignoreSelf = !0);
    t.forEach(o => {
        delete o._x_ignoreSelf, delete o._x_ignore
    }), t = null, n = null, r = null, i = null
}

function Ft(e) {
    return ne(z(e))
}

function te(e, t, n) {
    return e._x_dataStack = [t, ...z(n || e)], () => {
        e._x_dataStack = e._x_dataStack.filter(r => r !== t)
    }
}

function z(e) {
    return e._x_dataStack ? e._x_dataStack : typeof ShadowRoot == "function" && e instanceof ShadowRoot ? z(e.host) : e.parentNode ? z(e.parentNode) : []
}

function ne(e) {
    return new Proxy({
        objects: e
    }, nr)
}
var nr = {
    ownKeys({
        objects: e
    }) {
        return Array.from(new Set(e.flatMap(t => Object.keys(t))))
    },
    has({
        objects: e
    }, t) {
        return t == Symbol.unscopables ? !1 : e.some(n => Object.prototype.hasOwnProperty.call(n, t) || Reflect.has(n, t))
    },
    get({
        objects: e
    }, t, n) {
        return t == "toJSON" ? rr : Reflect.get(e.find(r => Reflect.has(r, t)) || {}, t, n)
    },
    set({
        objects: e
    }, t, n, r) {
        const i = e.find(s => Object.prototype.hasOwnProperty.call(s, t)) || e[e.length - 1],
            o = Object.getOwnPropertyDescriptor(i, t);
        return o != null && o.set && (o != null && o.get) ? o.set.call(r, n) || !0 : Reflect.set(i, t, n)
    }
};

function rr() {
    return Reflect.ownKeys(this).reduce((t, n) => (t[n] = Reflect.get(this, n), t), {})
}

function Dt(e) {
    let t = r => typeof r == "object" && !Array.isArray(r) && r !== null,
        n = (r, i = "") => {
            Object.entries(Object.getOwnPropertyDescriptors(r)).forEach(([o, {
                value: s,
                enumerable: a
            }]) => {
                if (a === !1 || s === void 0 || typeof s == "object" && s !== null && s.__v_skip) return;
                let u = i === "" ? o : `${i}.${o}`;
                typeof s == "object" && s !== null && s._x_interceptor ? r[o] = s.initialize(e, u, o) : t(s) && s !== r && !(s instanceof Element) && n(s, u)
            })
        };
    return n(e)
}

function Bt(e, t = () => {}) {
    let n = {
        initialValue: void 0,
        _x_interceptor: !0,
        initialize(r, i, o) {
            return e(this.initialValue, () => ir(r, i), s => Re(r, i, s), i, o)
        }
    };
    return t(n), r => {
        if (typeof r == "object" && r !== null && r._x_interceptor) {
            let i = n.initialize.bind(n);
            n.initialize = (o, s, a) => {
                let u = r.initialize(o, s, a);
                return n.initialValue = u, i(o, s, a)
            }
        } else n.initialValue = r;
        return n
    }
}

function ir(e, t) {
    return t.split(".").reduce((n, r) => n[r], e)
}

function Re(e, t, n) {
    if (typeof t == "string" && (t = t.split(".")), t.length === 1) e[t[0]] = n;
    else {
        if (t.length === 0) throw error;
        return e[t[0]] || (e[t[0]] = {}), Re(e[t[0]], t.slice(1), n)
    }
}
var kt = {};

function A(e, t) {
    kt[e] = t
}

function je(e, t) {
    return Object.entries(kt).forEach(([n, r]) => {
        let i = null;

        function o() {
            if (i) return i;
            {
                let [s, a] = Ut(t);
                return i = {
                    interceptor: Bt,
                    ...s
                }, Ue(t, a), i
            }
        }
        Object.defineProperty(e, `$${n}`, {
            get() {
                return r(t, o())
            },
            enumerable: !1
        })
    }), e
}

function or(e, t, n, ...r) {
    try {
        return n(...r)
    } catch (i) {
        ee(i, e, t)
    }
}

function ee(e, t, n = void 0) {
    e = Object.assign(e ?? {
        message: "No error message given."
    }, {
        el: t,
        expression: n
    }), console.warn(`Alpine Expression Error: ${e.message}

${n?'Expression: "'+n+`"

`:""}`, t), setTimeout(() => {
        throw e
    }, 0)
}
var fe = !0;

function Kt(e) {
    let t = fe;
    fe = !1;
    let n = e();
    return fe = t, n
}

function F(e, t, n = {}) {
    let r;
    return m(e, t)(i => r = i, n), r
}

function m(...e) {
    return zt(...e)
}
var zt = Ht;

function sr(e) {
    zt = e
}

function Ht(e, t) {
    let n = {};
    je(n, e);
    let r = [n, ...z(e)],
        i = typeof t == "function" ? ar(r, t) : cr(r, t, e);
    return or.bind(null, e, t, i)
}

function ar(e, t) {
    return (n = () => {}, {
        scope: r = {},
        params: i = []
    } = {}) => {
        let o = t.apply(ne([r, ...e]), i);
        _e(n, o)
    }
}
var Se = {};

function ur(e, t) {
    if (Se[e]) return Se[e];
    let n = Object.getPrototypeOf(async function() {}).constructor,
        r = /^[\n\s]*if.*\(.*\)/.test(e.trim()) || /^(let|const)\s/.test(e.trim()) ? `(async()=>{ ${e} })()` : e,
        o = (() => {
            try {
                let s = new n(["__self", "scope"], `with (scope) { __self.result = ${r} }; __self.finished = true; return __self.result;`);
                return Object.defineProperty(s, "name", {
                    value: `[Alpine] ${e}`
                }), s
            } catch (s) {
                return ee(s, t, e), Promise.resolve()
            }
        })();
    return Se[e] = o, o
}

function cr(e, t, n) {
    let r = ur(t, n);
    return (i = () => {}, {
        scope: o = {},
        params: s = []
    } = {}) => {
        r.result = void 0, r.finished = !1;
        let a = ne([o, ...e]);
        if (typeof r == "function") {
            let u = r(r, a).catch(c => ee(c, n, t));
            r.finished ? (_e(i, r.result, a, s, n), r.result = void 0) : u.then(c => {
                _e(i, c, a, s, n)
            }).catch(c => ee(c, n, t)).finally(() => r.result = void 0)
        }
    }
}

function _e(e, t, n, r, i) {
    if (fe && typeof t == "function") {
        let o = t.apply(n, r);
        o instanceof Promise ? o.then(s => _e(e, s, n, r)).catch(s => ee(s, i, t)) : e(o)
    } else typeof t == "object" && t instanceof Promise ? t.then(o => e(o)) : e(t)
}
var Ze = "x-";

function U(e = "") {
    return Ze + e
}

function lr(e) {
    Ze = e
}
var he = {};

function x(e, t) {
    return he[e] = t, {
        before(n) {
            if (!he[n]) {
                console.warn(String.raw`Cannot find directive \`${n}\`. \`${e}\` will use the default order of execution`);
                return
            }
            const r = L.indexOf(n);
            L.splice(r >= 0 ? r : L.indexOf("DEFAULT"), 0, e)
        }
    }
}

function fr(e) {
    return Object.keys(he).includes(e)
}

function Qe(e, t, n) {
    if (t = Array.from(t), e._x_virtualDirectives) {
        let o = Object.entries(e._x_virtualDirectives).map(([a, u]) => ({
                name: a,
                value: u
            })),
            s = qt(o);
        o = o.map(a => s.find(u => u.name === a.name) ? {
            name: `x-bind:${a.name}`,
            value: `"${a.value}"`
        } : a), t = t.concat(o)
    }
    let r = {};
    return t.map(Yt((o, s) => r[o] = s)).filter(Xt).map(_r(r, n)).sort(hr).map(o => pr(e, o))
}

function qt(e) {
    return Array.from(e).map(Yt()).filter(t => !Xt(t))
}
var Le = !1,
    X = new Map,
    Wt = Symbol();

function dr(e) {
    Le = !0;
    let t = Symbol();
    Wt = t, X.set(t, []);
    let n = () => {
            for (; X.get(t).length;) X.get(t).shift()();
            X.delete(t)
        },
        r = () => {
            Le = !1, n()
        };
    e(n), r()
}

function Ut(e) {
    let t = [],
        n = a => t.push(a),
        [r, i] = Gn(e);
    return t.push(i), [{
        Alpine: ie,
        effect: r,
        cleanup: n,
        evaluateLater: m.bind(m, e),
        evaluate: F.bind(F, e)
    }, () => t.forEach(a => a())]
}

function pr(e, t) {
    let n = () => {},
        r = he[t.type] || n,
        [i, o] = Ut(e);
    jt(e, t.original, o);
    let s = () => {
        e._x_ignore || e._x_ignoreSelf || (r.inline && r.inline(e, t, i), r = r.bind(r, e, t, i), Le ? X.get(Wt).push(r) : r())
    };
    return s.runCleanups = o, s
}
var Jt = (e, t) => ({
        name: n,
        value: r
    }) => (n.startsWith(e) && (n = n.replace(e, t)), {
        name: n,
        value: r
    }),
    Vt = e => e;

function Yt(e = () => {}) {
    return ({
        name: t,
        value: n
    }) => {
        let {
            name: r,
            value: i
        } = Gt.reduce((o, s) => s(o), {
            name: t,
            value: n
        });
        return r !== t && e(r, t), {
            name: r,
            value: i
        }
    }
}
var Gt = [];

function et(e) {
    Gt.push(e)
}

function Xt({
    name: e
}) {
    return Zt().test(e)
}
var Zt = () => new RegExp(`^${Ze}([^:^.]+)\\b`);

function _r(e, t) {
    return ({
        name: n,
        value: r
    }) => {
        let i = n.match(Zt()),
            o = n.match(/:([a-zA-Z0-9\-_:]+)/),
            s = n.match(/\.[^.\]]+(?=[^\]]*$)/g) || [],
            a = t || e[n] || n;
        return {
            type: i ? i[1] : null,
            value: o ? o[1] : null,
            modifiers: s.map(u => u.replace(".", "")),
            expression: r,
            original: a
        }
    }
}
var Ne = "DEFAULT",
    L = ["ignore", "ref", "data", "id", "anchor", "bind", "init", "for", "model", "modelable", "transition", "show", "if", Ne, "teleport"];

function hr(e, t) {
    let n = L.indexOf(e.type) === -1 ? Ne : e.type,
        r = L.indexOf(t.type) === -1 ? Ne : t.type;
    return L.indexOf(n) - L.indexOf(r)
}

function Z(e, t, n = {}) {
    e.dispatchEvent(new CustomEvent(t, {
        detail: n,
        bubbles: !0,
        composed: !0,
        cancelable: !0
    }))
}

function I(e, t) {
    if (typeof ShadowRoot == "function" && e instanceof ShadowRoot) {
        Array.from(e.children).forEach(i => I(i, t));
        return
    }
    let n = !1;
    if (t(e, () => n = !0), n) return;
    let r = e.firstElementChild;
    for (; r;) I(r, t), r = r.nextElementSibling
}

function E(e, ...t) {
    console.warn(`Alpine Warning: ${e}`, ...t)
}
var _t = !1;

function gr() {
    _t && E("Alpine has already been initialized on this page. Calling Alpine.start() more than once can cause problems."), _t = !0, document.body || E("Unable to initialize. Trying to load Alpine before `<body>` is available. Did you forget to add `defer` in Alpine's `<script>` tag?"), Z(document, "alpine:init"), Z(document, "alpine:initializing"), Ye(), Xn(t => C(t, I)), Ue(t => sn(t)), Rt((t, n) => {
        Qe(t, n).forEach(r => r())
    });
    let e = t => !xe(t.parentElement, !0);
    Array.from(document.querySelectorAll(tn().join(","))).filter(e).forEach(t => {
        C(t)
    }), Z(document, "alpine:initialized"), setTimeout(() => {
        vr()
    })
}
var tt = [],
    Qt = [];

function en() {
    return tt.map(e => e())
}

function tn() {
    return tt.concat(Qt).map(e => e())
}

function nn(e) {
    tt.push(e)
}

function rn(e) {
    Qt.push(e)
}

function xe(e, t = !1) {
    return re(e, n => {
        if ((t ? tn() : en()).some(i => n.matches(i))) return !0
    })
}

function re(e, t) {
    if (e) {
        if (t(e)) return e;
        if (e._x_teleportBack && (e = e._x_teleportBack), !!e.parentElement) return re(e.parentElement, t)
    }
}

function xr(e) {
    return en().some(t => e.matches(t))
}
var on = [];

function yr(e) {
    on.push(e)
}

function C(e, t = I, n = () => {}) {
    dr(() => {
        t(e, (r, i) => {
            n(r, i), on.forEach(o => o(r, i)), Qe(r, r.attributes).forEach(o => o()), r._x_ignore && i()
        })
    })
}

function sn(e, t = I) {
    t(e, n => {
        Lt(n), Zn(n)
    })
}

function vr() {
    [
        ["ui", "dialog", ["[x-dialog], [x-popover]"]],
        ["anchor", "anchor", ["[x-anchor]"]],
        ["sort", "sort", ["[x-sort]"]]
    ].forEach(([t, n, r]) => {
        fr(n) || r.some(i => {
            if (document.querySelector(i)) return E(`found "${i}", but missing ${t} plugin`), !0
        })
    })
}
var Fe = [],
    nt = !1;

function rt(e = () => {}) {
    return queueMicrotask(() => {
        nt || setTimeout(() => {
            De()
        })
    }), new Promise(t => {
        Fe.push(() => {
            e(), t()
        })
    })
}

function De() {
    for (nt = !1; Fe.length;) Fe.shift()()
}

function br() {
    nt = !0
}

function it(e, t) {
    return Array.isArray(t) ? ht(e, t.join(" ")) : typeof t == "object" && t !== null ? mr(e, t) : typeof t == "function" ? it(e, t()) : ht(e, t)
}

function ht(e, t) {
    let n = i => i.split(" ").filter(o => !e.classList.contains(o)).filter(Boolean),
        r = i => (e.classList.add(...i), () => {
            e.classList.remove(...i)
        });
    return t = t === !0 ? t = "" : t || "", r(n(t))
}

function mr(e, t) {
    let n = a => a.split(" ").filter(Boolean),
        r = Object.entries(t).flatMap(([a, u]) => u ? n(a) : !1).filter(Boolean),
        i = Object.entries(t).flatMap(([a, u]) => u ? !1 : n(a)).filter(Boolean),
        o = [],
        s = [];
    return i.forEach(a => {
        e.classList.contains(a) && (e.classList.remove(a), s.push(a))
    }), r.forEach(a => {
        e.classList.contains(a) || (e.classList.add(a), o.push(a))
    }), () => {
        s.forEach(a => e.classList.add(a)), o.forEach(a => e.classList.remove(a))
    }
}

function ye(e, t) {
    return typeof t == "object" && t !== null ? wr(e, t) : Er(e, t)
}

function wr(e, t) {
    let n = {};
    return Object.entries(t).forEach(([r, i]) => {
        n[r] = e.style[r], r.startsWith("--") || (r = Sr(r)), e.style.setProperty(r, i)
    }), setTimeout(() => {
        e.style.length === 0 && e.removeAttribute("style")
    }), () => {
        ye(e, n)
    }
}

function Er(e, t) {
    let n = e.getAttribute("style", t);
    return e.setAttribute("style", t), () => {
        e.setAttribute("style", n || "")
    }
}

function Sr(e) {
    return e.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase()
}

function Be(e, t = () => {}) {
    let n = !1;
    return function() {
        n ? t.apply(this, arguments) : (n = !0, e.apply(this, arguments))
    }
}
x("transition", (e, {
    value: t,
    modifiers: n,
    expression: r
}, {
    evaluate: i
}) => {
    typeof r == "function" && (r = i(r)), r !== !1 && (!r || typeof r == "boolean" ? Or(e, n, t) : Ar(e, r, t))
});

function Ar(e, t, n) {
    an(e, it, ""), {
        enter: i => {
            e._x_transition.enter.during = i
        },
        "enter-start": i => {
            e._x_transition.enter.start = i
        },
        "enter-end": i => {
            e._x_transition.enter.end = i
        },
        leave: i => {
            e._x_transition.leave.during = i
        },
        "leave-start": i => {
            e._x_transition.leave.start = i
        },
        "leave-end": i => {
            e._x_transition.leave.end = i
        }
    } [n](t)
}

function Or(e, t, n) {
    an(e, ye);
    let r = !t.includes("in") && !t.includes("out") && !n,
        i = r || t.includes("in") || ["enter"].includes(n),
        o = r || t.includes("out") || ["leave"].includes(n);
    t.includes("in") && !r && (t = t.filter((_, g) => g < t.indexOf("out"))), t.includes("out") && !r && (t = t.filter((_, g) => g > t.indexOf("out")));
    let s = !t.includes("opacity") && !t.includes("scale"),
        a = s || t.includes("opacity"),
        u = s || t.includes("scale"),
        c = a ? 0 : 1,
        l = u ? Y(t, "scale", 95) / 100 : 1,
        d = Y(t, "delay", 0) / 1e3,
        p = Y(t, "origin", "center"),
        v = "opacity, transform",
        M = Y(t, "duration", 150) / 1e3,
        oe = Y(t, "duration", 75) / 1e3,
        f = "cubic-bezier(0.4, 0.0, 0.2, 1)";
    i && (e._x_transition.enter.during = {
        transformOrigin: p,
        transitionDelay: `${d}s`,
        transitionProperty: v,
        transitionDuration: `${M}s`,
        transitionTimingFunction: f
    }, e._x_transition.enter.start = {
        opacity: c,
        transform: `scale(${l})`
    }, e._x_transition.enter.end = {
        opacity: 1,
        transform: "scale(1)"
    }), o && (e._x_transition.leave.during = {
        transformOrigin: p,
        transitionDelay: `${d}s`,
        transitionProperty: v,
        transitionDuration: `${oe}s`,
        transitionTimingFunction: f
    }, e._x_transition.leave.start = {
        opacity: 1,
        transform: "scale(1)"
    }, e._x_transition.leave.end = {
        opacity: c,
        transform: `scale(${l})`
    })
}

function an(e, t, n = {}) {
    e._x_transition || (e._x_transition = {
        enter: {
            during: n,
            start: n,
            end: n
        },
        leave: {
            during: n,
            start: n,
            end: n
        },
        in(r = () => {}, i = () => {}) {
            ke(e, t, {
                during: this.enter.during,
                start: this.enter.start,
                end: this.enter.end
            }, r, i)
        },
        out(r = () => {}, i = () => {}) {
            ke(e, t, {
                during: this.leave.during,
                start: this.leave.start,
                end: this.leave.end
            }, r, i)
        }
    })
}
window.Element.prototype._x_toggleAndCascadeWithTransitions = function(e, t, n, r) {
    const i = document.visibilityState === "visible" ? requestAnimationFrame : setTimeout;
    let o = () => i(n);
    if (t) {
        e._x_transition && (e._x_transition.enter || e._x_transition.leave) ? e._x_transition.enter && (Object.entries(e._x_transition.enter.during).length || Object.entries(e._x_transition.enter.start).length || Object.entries(e._x_transition.enter.end).length) ? e._x_transition.in(n) : o() : e._x_transition ? e._x_transition.in(n) : o();
        return
    }
    e._x_hidePromise = e._x_transition ? new Promise((s, a) => {
        e._x_transition.out(() => {}, () => s(r)), e._x_transitioning && e._x_transitioning.beforeCancel(() => a({
            isFromCancelledTransition: !0
        }))
    }) : Promise.resolve(r), queueMicrotask(() => {
        let s = un(e);
        s ? (s._x_hideChildren || (s._x_hideChildren = []), s._x_hideChildren.push(e)) : i(() => {
            let a = u => {
                let c = Promise.all([u._x_hidePromise, ...(u._x_hideChildren || []).map(a)]).then(([l]) => l == null ? void 0 : l());
                return delete u._x_hidePromise, delete u._x_hideChildren, c
            };
            a(e).catch(u => {
                if (!u.isFromCancelledTransition) throw u
            })
        })
    })
};

function un(e) {
    let t = e.parentNode;
    if (t) return t._x_hidePromise ? t : un(t)
}

function ke(e, t, {
    during: n,
    start: r,
    end: i
} = {}, o = () => {}, s = () => {}) {
    if (e._x_transitioning && e._x_transitioning.cancel(), Object.keys(n).length === 0 && Object.keys(r).length === 0 && Object.keys(i).length === 0) {
        o(), s();
        return
    }
    let a, u, c;
    Cr(e, {
        start() {
            a = t(e, r)
        },
        during() {
            u = t(e, n)
        },
        before: o,
        end() {
            a(), c = t(e, i)
        },
        after: s,
        cleanup() {
            u(), c()
        }
    })
}

function Cr(e, t) {
    let n, r, i, o = Be(() => {
        y(() => {
            n = !0, r || t.before(), i || (t.end(), De()), t.after(), e.isConnected && t.cleanup(), delete e._x_transitioning
        })
    });
    e._x_transitioning = {
        beforeCancels: [],
        beforeCancel(s) {
            this.beforeCancels.push(s)
        },
        cancel: Be(function() {
            for (; this.beforeCancels.length;) this.beforeCancels.shift()();
            o()
        }),
        finish: o
    }, y(() => {
        t.start(), t.during()
    }), br(), requestAnimationFrame(() => {
        if (n) return;
        let s = Number(getComputedStyle(e).transitionDuration.replace(/,.*/, "").replace("s", "")) * 1e3,
            a = Number(getComputedStyle(e).transitionDelay.replace(/,.*/, "").replace("s", "")) * 1e3;
        s === 0 && (s = Number(getComputedStyle(e).animationDuration.replace("s", "")) * 1e3), y(() => {
            t.before()
        }), r = !0, requestAnimationFrame(() => {
            n || (y(() => {
                t.end()
            }), De(), setTimeout(e._x_transitioning.finish, s + a), i = !0)
        })
    })
}

function Y(e, t, n) {
    if (e.indexOf(t) === -1) return n;
    const r = e[e.indexOf(t) + 1];
    if (!r || t === "scale" && isNaN(r)) return n;
    if (t === "duration" || t === "delay") {
        let i = r.match(/([0-9]+)ms/);
        if (i) return i[1]
    }
    return t === "origin" && ["top", "right", "left", "center", "bottom"].includes(e[e.indexOf(t) + 2]) ? [r, e[e.indexOf(t) + 2]].join(" ") : r
}
var $ = !1;

function R(e, t = () => {}) {
    return (...n) => $ ? t(...n) : e(...n)
}

function Mr(e) {
    return (...t) => $ && e(...t)
}
var cn = [];

function ve(e) {
    cn.push(e)
}

function Tr(e, t) {
    cn.forEach(n => n(e, t)), $ = !0, ln(() => {
        C(t, (n, r) => {
            r(n, () => {})
        })
    }), $ = !1
}
var Ke = !1;

function Ir(e, t) {
    t._x_dataStack || (t._x_dataStack = e._x_dataStack), $ = !0, Ke = !0, ln(() => {
        $r(t)
    }), $ = !1, Ke = !1
}

function $r(e) {
    let t = !1;
    C(e, (r, i) => {
        I(r, (o, s) => {
            if (t && xr(o)) return s();
            t = !0, i(o, s)
        })
    })
}

function ln(e) {
    let t = k;
    pt((n, r) => {
        let i = t(n);
        return W(i), () => {}
    }), e(), pt(t)
}

function fn(e, t, n, r = []) {
    switch (e._x_bindings || (e._x_bindings = q({})), e._x_bindings[t] = n, t = r.includes("camel") ? Br(t) : t, t) {
        case "value":
            Pr(e, n);
            break;
        case "style":
            jr(e, n);
            break;
        case "class":
            Rr(e, n);
            break;
        case "selected":
        case "checked":
            Lr(e, t, n);
            break;
        default:
            dn(e, t, n);
            break
    }
}

function Pr(e, t) {
    if (e.type === "radio") e.attributes.value === void 0 && (e.value = t), window.fromModel && (typeof t == "boolean" ? e.checked = de(e.value) === t : e.checked = gt(e.value, t));
    else if (e.type === "checkbox") Number.isInteger(t) ? e.value = t : !Array.isArray(t) && typeof t != "boolean" && ![null, void 0].includes(t) ? e.value = String(t) : Array.isArray(t) ? e.checked = t.some(n => gt(n, e.value)) : e.checked = !!t;
    else if (e.tagName === "SELECT") Dr(e, t);
    else {
        if (e.value === t) return;
        e.value = t === void 0 ? "" : t
    }
}

function Rr(e, t) {
    e._x_undoAddedClasses && e._x_undoAddedClasses(), e._x_undoAddedClasses = it(e, t)
}

function jr(e, t) {
    e._x_undoAddedStyles && e._x_undoAddedStyles(), e._x_undoAddedStyles = ye(e, t)
}

function Lr(e, t, n) {
    dn(e, t, n), Fr(e, t, n)
}

function dn(e, t, n) {
    [null, void 0, !1].includes(n) && kr(t) ? e.removeAttribute(t) : (pn(t) && (n = t), Nr(e, t, n))
}

function Nr(e, t, n) {
    e.getAttribute(t) != n && e.setAttribute(t, n)
}

function Fr(e, t, n) {
    e[t] !== n && (e[t] = n)
}

function Dr(e, t) {
    const n = [].concat(t).map(r => r + "");
    Array.from(e.options).forEach(r => {
        r.selected = n.includes(r.value)
    })
}

function Br(e) {
    return e.toLowerCase().replace(/-(\w)/g, (t, n) => n.toUpperCase())
}

function gt(e, t) {
    return e == t
}

function de(e) {
    return [1, "1", "true", "on", "yes", !0].includes(e) ? !0 : [0, "0", "false", "off", "no", !1].includes(e) ? !1 : e ? !!e : null
}

function pn(e) {
    return ["disabled", "checked", "required", "readonly", "open", "selected", "autofocus", "itemscope", "multiple", "novalidate", "allowfullscreen", "allowpaymentrequest", "formnovalidate", "autoplay", "controls", "loop", "muted", "playsinline", "default", "ismap", "reversed", "async", "defer", "nomodule"].includes(e)
}

function kr(e) {
    return !["aria-pressed", "aria-checked", "aria-expanded", "aria-selected"].includes(e)
}

function Kr(e, t, n) {
    return e._x_bindings && e._x_bindings[t] !== void 0 ? e._x_bindings[t] : _n(e, t, n)
}

function zr(e, t, n, r = !0) {
    if (e._x_bindings && e._x_bindings[t] !== void 0) return e._x_bindings[t];
    if (e._x_inlineBindings && e._x_inlineBindings[t] !== void 0) {
        let i = e._x_inlineBindings[t];
        return i.extract = r, Kt(() => F(e, i.expression))
    }
    return _n(e, t, n)
}

function _n(e, t, n) {
    let r = e.getAttribute(t);
    return r === null ? typeof n == "function" ? n() : n : r === "" ? !0 : pn(t) ? !![t, "true"].includes(r) : r
}

function hn(e, t) {
    var n;
    return function() {
        var r = this,
            i = arguments,
            o = function() {
                n = null, e.apply(r, i)
            };
        clearTimeout(n), n = setTimeout(o, t)
    }
}

function gn(e, t) {
    let n;
    return function() {
        let r = this,
            i = arguments;
        n || (e.apply(r, i), n = !0, setTimeout(() => n = !1, t))
    }
}

function xn({
    get: e,
    set: t
}, {
    get: n,
    set: r
}) {
    let i = !0,
        o, s = k(() => {
            let a = e(),
                u = n();
            if (i) r(Ae(a)), i = !1;
            else {
                let c = JSON.stringify(a),
                    l = JSON.stringify(u);
                c !== o ? r(Ae(a)) : c !== l && t(Ae(u))
            }
            o = JSON.stringify(e()), JSON.stringify(n())
        });
    return () => {
        W(s)
    }
}

function Ae(e) {
    return typeof e == "object" ? JSON.parse(JSON.stringify(e)) : e
}

function Hr(e) {
    (Array.isArray(e) ? e : [e]).forEach(n => n(ie))
}
var j = {},
    xt = !1;

function qr(e, t) {
    if (xt || (j = q(j), xt = !0), t === void 0) return j[e];
    j[e] = t, typeof t == "object" && t !== null && t.hasOwnProperty("init") && typeof t.init == "function" && j[e].init(), Dt(j[e])
}

function Wr() {
    return j
}
var yn = {};

function Ur(e, t) {
    let n = typeof t != "function" ? () => t : t;
    return e instanceof Element ? vn(e, n()) : (yn[e] = n, () => {})
}

function Jr(e) {
    return Object.entries(yn).forEach(([t, n]) => {
        Object.defineProperty(e, t, {
            get() {
                return (...r) => n(...r)
            }
        })
    }), e
}

function vn(e, t, n) {
    let r = [];
    for (; r.length;) r.pop()();
    let i = Object.entries(t).map(([s, a]) => ({
            name: s,
            value: a
        })),
        o = qt(i);
    return i = i.map(s => o.find(a => a.name === s.name) ? {
        name: `x-bind:${s.name}`,
        value: `"${s.value}"`
    } : s), Qe(e, i, n).map(s => {
        r.push(s.runCleanups), s()
    }), () => {
        for (; r.length;) r.pop()()
    }
}
var bn = {};

function Vr(e, t) {
    bn[e] = t
}

function Yr(e, t) {
    return Object.entries(bn).forEach(([n, r]) => {
        Object.defineProperty(e, n, {
            get() {
                return (...i) => r.bind(t)(...i)
            },
            enumerable: !1
        })
    }), e
}
var Gr = {
        get reactive() {
            return q
        },
        get release() {
            return W
        },
        get effect() {
            return k
        },
        get raw() {
            return Mt
        },
        version: "3.14.1",
        flushAndStopDeferringMutations: tr,
        dontAutoEvaluateFunctions: Kt,
        disableEffectScheduling: Vn,
        startObservingMutations: Ye,
        stopObservingMutations: Nt,
        setReactivityEngine: Yn,
        onAttributeRemoved: jt,
        onAttributesAdded: Rt,
        closestDataStack: z,
        skipDuringClone: R,
        onlyDuringClone: Mr,
        addRootSelector: nn,
        addInitSelector: rn,
        interceptClone: ve,
        addScopeToNode: te,
        deferMutations: er,
        mapAttributes: et,
        evaluateLater: m,
        interceptInit: yr,
        setEvaluator: sr,
        mergeProxies: ne,
        extractProp: zr,
        findClosest: re,
        onElRemoved: Ue,
        closestRoot: xe,
        destroyTree: sn,
        interceptor: Bt,
        transition: ke,
        setStyles: ye,
        mutateDom: y,
        directive: x,
        entangle: xn,
        throttle: gn,
        debounce: hn,
        evaluate: F,
        initTree: C,
        nextTick: rt,
        prefixed: U,
        prefix: lr,
        plugin: Hr,
        magic: A,
        store: qr,
        start: gr,
        clone: Ir,
        cloneNode: Tr,
        bound: Kr,
        $data: Ft,
        watch: Tt,
        walk: I,
        data: Vr,
        bind: Ur
    },
    ie = Gr;

function Xr(e, t) {
    const n = Object.create(null),
        r = e.split(",");
    for (let i = 0; i < r.length; i++) n[r[i]] = !0;
    return i => !!n[i]
}
var Zr = Object.freeze({}),
    Qr = Object.prototype.hasOwnProperty,
    be = (e, t) => Qr.call(e, t),
    D = Array.isArray,
    Q = e => mn(e) === "[object Map]",
    ei = e => typeof e == "string",
    ot = e => typeof e == "symbol",
    me = e => e !== null && typeof e == "object",
    ti = Object.prototype.toString,
    mn = e => ti.call(e),
    wn = e => mn(e).slice(8, -1),
    st = e => ei(e) && e !== "NaN" && e[0] !== "-" && "" + parseInt(e, 10) === e,
    ni = e => {
        const t = Object.create(null);
        return n => t[n] || (t[n] = e(n))
    },
    ri = ni(e => e.charAt(0).toUpperCase() + e.slice(1)),
    En = (e, t) => e !== t && (e === e || t === t),
    ze = new WeakMap,
    G = [],
    O, B = Symbol("iterate"),
    He = Symbol("Map key iterate");

function ii(e) {
    return e && e._isEffect === !0
}

function oi(e, t = Zr) {
    ii(e) && (e = e.raw);
    const n = ui(e, t);
    return t.lazy || n(), n
}

function si(e) {
    e.active && (Sn(e), e.options.onStop && e.options.onStop(), e.active = !1)
}
var ai = 0;

function ui(e, t) {
    const n = function() {
        if (!n.active) return e();
        if (!G.includes(n)) {
            Sn(n);
            try {
                return li(), G.push(n), O = n, e()
            } finally {
                G.pop(), An(), O = G[G.length - 1]
            }
        }
    };
    return n.id = ai++, n.allowRecurse = !!t.allowRecurse, n._isEffect = !0, n.active = !0, n.raw = e, n.deps = [], n.options = t, n
}

function Sn(e) {
    const {
        deps: t
    } = e;
    if (t.length) {
        for (let n = 0; n < t.length; n++) t[n].delete(e);
        t.length = 0
    }
}
var H = !0,
    at = [];

function ci() {
    at.push(H), H = !1
}

function li() {
    at.push(H), H = !0
}

function An() {
    const e = at.pop();
    H = e === void 0 ? !0 : e
}

function S(e, t, n) {
    if (!H || O === void 0) return;
    let r = ze.get(e);
    r || ze.set(e, r = new Map);
    let i = r.get(n);
    i || r.set(n, i = new Set), i.has(O) || (i.add(O), O.deps.push(i), O.options.onTrack && O.options.onTrack({
        effect: O,
        target: e,
        type: t,
        key: n
    }))
}

function P(e, t, n, r, i, o) {
    const s = ze.get(e);
    if (!s) return;
    const a = new Set,
        u = l => {
            l && l.forEach(d => {
                (d !== O || d.allowRecurse) && a.add(d)
            })
        };
    if (t === "clear") s.forEach(u);
    else if (n === "length" && D(e)) s.forEach((l, d) => {
        (d === "length" || d >= r) && u(l)
    });
    else switch (n !== void 0 && u(s.get(n)), t) {
        case "add":
            D(e) ? st(n) && u(s.get("length")) : (u(s.get(B)), Q(e) && u(s.get(He)));
            break;
        case "delete":
            D(e) || (u(s.get(B)), Q(e) && u(s.get(He)));
            break;
        case "set":
            Q(e) && u(s.get(B));
            break
    }
    const c = l => {
        l.options.onTrigger && l.options.onTrigger({
            effect: l,
            target: e,
            key: n,
            type: t,
            newValue: r,
            oldValue: i,
            oldTarget: o
        }), l.options.scheduler ? l.options.scheduler(l) : l()
    };
    a.forEach(c)
}
var fi = Xr("__proto__,__v_isRef,__isVue"),
    On = new Set(Object.getOwnPropertyNames(Symbol).map(e => Symbol[e]).filter(ot)),
    di = Cn(),
    pi = Cn(!0),
    yt = _i();

function _i() {
    const e = {};
    return ["includes", "indexOf", "lastIndexOf"].forEach(t => {
        e[t] = function(...n) {
            const r = h(this);
            for (let o = 0, s = this.length; o < s; o++) S(r, "get", o + "");
            const i = r[t](...n);
            return i === -1 || i === !1 ? r[t](...n.map(h)) : i
        }
    }), ["push", "pop", "shift", "unshift", "splice"].forEach(t => {
        e[t] = function(...n) {
            ci();
            const r = h(this)[t].apply(this, n);
            return An(), r
        }
    }), e
}

function Cn(e = !1, t = !1) {
    return function(r, i, o) {
        if (i === "__v_isReactive") return !e;
        if (i === "__v_isReadonly") return e;
        if (i === "__v_raw" && o === (e ? t ? Mi : $n : t ? Ci : In).get(r)) return r;
        const s = D(r);
        if (!e && s && be(yt, i)) return Reflect.get(yt, i, o);
        const a = Reflect.get(r, i, o);
        return (ot(i) ? On.has(i) : fi(i)) || (e || S(r, "get", i), t) ? a : qe(a) ? !s || !st(i) ? a.value : a : me(a) ? e ? Pn(a) : ft(a) : a
    }
}
var hi = gi();

function gi(e = !1) {
    return function(n, r, i, o) {
        let s = n[r];
        if (!e && (i = h(i), s = h(s), !D(n) && qe(s) && !qe(i))) return s.value = i, !0;
        const a = D(n) && st(r) ? Number(r) < n.length : be(n, r),
            u = Reflect.set(n, r, i, o);
        return n === h(o) && (a ? En(i, s) && P(n, "set", r, i, s) : P(n, "add", r, i)), u
    }
}

function xi(e, t) {
    const n = be(e, t),
        r = e[t],
        i = Reflect.deleteProperty(e, t);
    return i && n && P(e, "delete", t, void 0, r), i
}

function yi(e, t) {
    const n = Reflect.has(e, t);
    return (!ot(t) || !On.has(t)) && S(e, "has", t), n
}

function vi(e) {
    return S(e, "iterate", D(e) ? "length" : B), Reflect.ownKeys(e)
}
var bi = {
        get: di,
        set: hi,
        deleteProperty: xi,
        has: yi,
        ownKeys: vi
    },
    mi = {
        get: pi,
        set(e, t) {
            return console.warn(`Set operation on key "${String(t)}" failed: target is readonly.`, e), !0
        },
        deleteProperty(e, t) {
            return console.warn(`Delete operation on key "${String(t)}" failed: target is readonly.`, e), !0
        }
    },
    ut = e => me(e) ? ft(e) : e,
    ct = e => me(e) ? Pn(e) : e,
    lt = e => e,
    we = e => Reflect.getPrototypeOf(e);

function se(e, t, n = !1, r = !1) {
    e = e.__v_raw;
    const i = h(e),
        o = h(t);
    t !== o && !n && S(i, "get", t), !n && S(i, "get", o);
    const {
        has: s
    } = we(i), a = r ? lt : n ? ct : ut;
    if (s.call(i, t)) return a(e.get(t));
    if (s.call(i, o)) return a(e.get(o));
    e !== i && e.get(t)
}

function ae(e, t = !1) {
    const n = this.__v_raw,
        r = h(n),
        i = h(e);
    return e !== i && !t && S(r, "has", e), !t && S(r, "has", i), e === i ? n.has(e) : n.has(e) || n.has(i)
}

function ue(e, t = !1) {
    return e = e.__v_raw, !t && S(h(e), "iterate", B), Reflect.get(e, "size", e)
}

function vt(e) {
    e = h(e);
    const t = h(this);
    return we(t).has.call(t, e) || (t.add(e), P(t, "add", e, e)), this
}

function bt(e, t) {
    t = h(t);
    const n = h(this),
        {
            has: r,
            get: i
        } = we(n);
    let o = r.call(n, e);
    o ? Tn(n, r, e) : (e = h(e), o = r.call(n, e));
    const s = i.call(n, e);
    return n.set(e, t), o ? En(t, s) && P(n, "set", e, t, s) : P(n, "add", e, t), this
}

function mt(e) {
    const t = h(this),
        {
            has: n,
            get: r
        } = we(t);
    let i = n.call(t, e);
    i ? Tn(t, n, e) : (e = h(e), i = n.call(t, e));
    const o = r ? r.call(t, e) : void 0,
        s = t.delete(e);
    return i && P(t, "delete", e, void 0, o), s
}

function wt() {
    const e = h(this),
        t = e.size !== 0,
        n = Q(e) ? new Map(e) : new Set(e),
        r = e.clear();
    return t && P(e, "clear", void 0, void 0, n), r
}

function ce(e, t) {
    return function(r, i) {
        const o = this,
            s = o.__v_raw,
            a = h(s),
            u = t ? lt : e ? ct : ut;
        return !e && S(a, "iterate", B), s.forEach((c, l) => r.call(i, u(c), u(l), o))
    }
}

function le(e, t, n) {
    return function(...r) {
        const i = this.__v_raw,
            o = h(i),
            s = Q(o),
            a = e === "entries" || e === Symbol.iterator && s,
            u = e === "keys" && s,
            c = i[e](...r),
            l = n ? lt : t ? ct : ut;
        return !t && S(o, "iterate", u ? He : B), {
            next() {
                const {
                    value: d,
                    done: p
                } = c.next();
                return p ? {
                    value: d,
                    done: p
                } : {
                    value: a ? [l(d[0]), l(d[1])] : l(d),
                    done: p
                }
            },
            [Symbol.iterator]() {
                return this
            }
        }
    }
}

function T(e) {
    return function(...t) {
        {
            const n = t[0] ? `on key "${t[0]}" ` : "";
            console.warn(`${ri(e)} operation ${n}failed: target is readonly.`, h(this))
        }
        return e === "delete" ? !1 : this
    }
}

function wi() {
    const e = {
            get(o) {
                return se(this, o)
            },
            get size() {
                return ue(this)
            },
            has: ae,
            add: vt,
            set: bt,
            delete: mt,
            clear: wt,
            forEach: ce(!1, !1)
        },
        t = {
            get(o) {
                return se(this, o, !1, !0)
            },
            get size() {
                return ue(this)
            },
            has: ae,
            add: vt,
            set: bt,
            delete: mt,
            clear: wt,
            forEach: ce(!1, !0)
        },
        n = {
            get(o) {
                return se(this, o, !0)
            },
            get size() {
                return ue(this, !0)
            },
            has(o) {
                return ae.call(this, o, !0)
            },
            add: T("add"),
            set: T("set"),
            delete: T("delete"),
            clear: T("clear"),
            forEach: ce(!0, !1)
        },
        r = {
            get(o) {
                return se(this, o, !0, !0)
            },
            get size() {
                return ue(this, !0)
            },
            has(o) {
                return ae.call(this, o, !0)
            },
            add: T("add"),
            set: T("set"),
            delete: T("delete"),
            clear: T("clear"),
            forEach: ce(!0, !0)
        };
    return ["keys", "values", "entries", Symbol.iterator].forEach(o => {
        e[o] = le(o, !1, !1), n[o] = le(o, !0, !1), t[o] = le(o, !1, !0), r[o] = le(o, !0, !0)
    }), [e, n, t, r]
}
var [Ei, Si, Xi, Zi] = wi();

function Mn(e, t) {
    const n = e ? Si : Ei;
    return (r, i, o) => i === "__v_isReactive" ? !e : i === "__v_isReadonly" ? e : i === "__v_raw" ? r : Reflect.get(be(n, i) && i in r ? n : r, i, o)
}
var Ai = {
        get: Mn(!1)
    },
    Oi = {
        get: Mn(!0)
    };

function Tn(e, t, n) {
    const r = h(n);
    if (r !== n && t.call(e, r)) {
        const i = wn(e);
        console.warn(`Reactive ${i} contains both the raw and reactive versions of the same object${i==="Map"?" as keys":""}, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`)
    }
}
var In = new WeakMap,
    Ci = new WeakMap,
    $n = new WeakMap,
    Mi = new WeakMap;

function Ti(e) {
    switch (e) {
        case "Object":
        case "Array":
            return 1;
        case "Map":
        case "Set":
        case "WeakMap":
        case "WeakSet":
            return 2;
        default:
            return 0
    }
}

function Ii(e) {
    return e.__v_skip || !Object.isExtensible(e) ? 0 : Ti(wn(e))
}

function ft(e) {
    return e && e.__v_isReadonly ? e : Rn(e, !1, bi, Ai, In)
}

function Pn(e) {
    return Rn(e, !0, mi, Oi, $n)
}

function Rn(e, t, n, r, i) {
    if (!me(e)) return console.warn(`value cannot be made reactive: ${String(e)}`), e;
    if (e.__v_raw && !(t && e.__v_isReactive)) return e;
    const o = i.get(e);
    if (o) return o;
    const s = Ii(e);
    if (s === 0) return e;
    const a = new Proxy(e, s === 2 ? r : n);
    return i.set(e, a), a
}

function h(e) {
    return e && h(e.__v_raw) || e
}

function qe(e) {
    return !!(e && e.__v_isRef === !0)
}
A("nextTick", () => rt);
A("dispatch", e => Z.bind(Z, e));
A("watch", (e, {
    evaluateLater: t,
    cleanup: n
}) => (r, i) => {
    let o = t(r),
        a = Tt(() => {
            let u;
            return o(c => u = c), u
        }, i);
    n(a)
});
A("store", Wr);
A("data", e => Ft(e));
A("root", e => xe(e));
A("refs", e => (e._x_refs_proxy || (e._x_refs_proxy = ne($i(e))), e._x_refs_proxy));

function $i(e) {
    let t = [];
    return re(e, n => {
        n._x_refs && t.push(n._x_refs)
    }), t
}
var Oe = {};

function jn(e) {
    return Oe[e] || (Oe[e] = 0), ++Oe[e]
}

function Pi(e, t) {
    return re(e, n => {
        if (n._x_ids && n._x_ids[t]) return !0
    })
}

function Ri(e, t) {
    e._x_ids || (e._x_ids = {}), e._x_ids[t] || (e._x_ids[t] = jn(t))
}
A("id", (e, {
    cleanup: t
}) => (n, r = null) => {
    let i = `${n}${r?`-${r}`:""}`;
    return ji(e, i, t, () => {
        let o = Pi(e, n),
            s = o ? o._x_ids[n] : jn(n);
        return r ? `${n}-${s}-${r}` : `${n}-${s}`
    })
});
ve((e, t) => {
    e._x_id && (t._x_id = e._x_id)
});

function ji(e, t, n, r) {
    if (e._x_id || (e._x_id = {}), e._x_id[t]) return e._x_id[t];
    let i = r();
    return e._x_id[t] = i, n(() => {
        delete e._x_id[t]
    }), i
}
A("el", e => e);
Ln("Focus", "focus", "focus");
Ln("Persist", "persist", "persist");

function Ln(e, t, n) {
    A(t, r => E(`You can't use [$${t}] without first installing the "${e}" plugin here: https://alpinejs.dev/plugins/${n}`, r))
}
x("modelable", (e, {
    expression: t
}, {
    effect: n,
    evaluateLater: r,
    cleanup: i
}) => {
    let o = r(t),
        s = () => {
            let l;
            return o(d => l = d), l
        },
        a = r(`${t} = __placeholder`),
        u = l => a(() => {}, {
            scope: {
                __placeholder: l
            }
        }),
        c = s();
    u(c), queueMicrotask(() => {
        if (!e._x_model) return;
        e._x_removeModelListeners.default();
        let l = e._x_model.get,
            d = e._x_model.set,
            p = xn({
                get() {
                    return l()
                },
                set(v) {
                    d(v)
                }
            }, {
                get() {
                    return s()
                },
                set(v) {
                    u(v)
                }
            });
        i(p)
    })
});
x("teleport", (e, {
    modifiers: t,
    expression: n
}, {
    cleanup: r
}) => {
    e.tagName.toLowerCase() !== "template" && E("x-teleport can only be used on a <template> tag", e);
    let i = Et(n),
        o = e.content.cloneNode(!0).firstElementChild;
    e._x_teleport = o, o._x_teleportBack = e, e.setAttribute("data-teleport-template", !0), o.setAttribute("data-teleport-target", !0), e._x_forwardEvents && e._x_forwardEvents.forEach(a => {
        o.addEventListener(a, u => {
            u.stopPropagation(), e.dispatchEvent(new u.constructor(u.type, u))
        })
    }), te(o, {}, e);
    let s = (a, u, c) => {
        c.includes("prepend") ? u.parentNode.insertBefore(a, u) : c.includes("append") ? u.parentNode.insertBefore(a, u.nextSibling) : u.appendChild(a)
    };
    y(() => {
        s(o, i, t), R(() => {
            C(o), o._x_ignore = !0
        })()
    }), e._x_teleportPutBack = () => {
        let a = Et(n);
        y(() => {
            s(e._x_teleport, a, t)
        })
    }, r(() => o.remove())
});
var Li = document.createElement("div");

function Et(e) {
    let t = R(() => document.querySelector(e), () => Li)();
    return t || E(`Cannot find x-teleport element for selector: "${e}"`), t
}
var Nn = () => {};
Nn.inline = (e, {
    modifiers: t
}, {
    cleanup: n
}) => {
    t.includes("self") ? e._x_ignoreSelf = !0 : e._x_ignore = !0, n(() => {
        t.includes("self") ? delete e._x_ignoreSelf : delete e._x_ignore
    })
};
x("ignore", Nn);
x("effect", R((e, {
    expression: t
}, {
    effect: n
}) => {
    n(m(e, t))
}));

function We(e, t, n, r) {
    let i = e,
        o = u => r(u),
        s = {},
        a = (u, c) => l => c(u, l);
    if (n.includes("dot") && (t = Ni(t)), n.includes("camel") && (t = Fi(t)), n.includes("passive") && (s.passive = !0), n.includes("capture") && (s.capture = !0), n.includes("window") && (i = window), n.includes("document") && (i = document), n.includes("debounce")) {
        let u = n[n.indexOf("debounce") + 1] || "invalid-wait",
            c = ge(u.split("ms")[0]) ? Number(u.split("ms")[0]) : 250;
        o = hn(o, c)
    }
    if (n.includes("throttle")) {
        let u = n[n.indexOf("throttle") + 1] || "invalid-wait",
            c = ge(u.split("ms")[0]) ? Number(u.split("ms")[0]) : 250;
        o = gn(o, c)
    }
    return n.includes("prevent") && (o = a(o, (u, c) => {
        c.preventDefault(), u(c)
    })), n.includes("stop") && (o = a(o, (u, c) => {
        c.stopPropagation(), u(c)
    })), n.includes("once") && (o = a(o, (u, c) => {
        u(c), i.removeEventListener(t, o, s)
    })), (n.includes("away") || n.includes("outside")) && (i = document, o = a(o, (u, c) => {
        e.contains(c.target) || c.target.isConnected !== !1 && (e.offsetWidth < 1 && e.offsetHeight < 1 || e._x_isShown !== !1 && u(c))
    })), n.includes("self") && (o = a(o, (u, c) => {
        c.target === e && u(c)
    })), (Bi(t) || Fn(t)) && (o = a(o, (u, c) => {
        ki(c, n) || u(c)
    })), i.addEventListener(t, o, s), () => {
        i.removeEventListener(t, o, s)
    }
}

function Ni(e) {
    return e.replace(/-/g, ".")
}

function Fi(e) {
    return e.toLowerCase().replace(/-(\w)/g, (t, n) => n.toUpperCase())
}

function ge(e) {
    return !Array.isArray(e) && !isNaN(e)
}

function Di(e) {
    return [" ", "_"].includes(e) ? e : e.replace(/([a-z])([A-Z])/g, "$1-$2").replace(/[_\s]/, "-").toLowerCase()
}

function Bi(e) {
    return ["keydown", "keyup"].includes(e)
}

function Fn(e) {
    return ["contextmenu", "click", "mouse"].some(t => e.includes(t))
}

function ki(e, t) {
    let n = t.filter(o => !["window", "document", "prevent", "stop", "once", "capture", "self", "away", "outside", "passive"].includes(o));
    if (n.includes("debounce")) {
        let o = n.indexOf("debounce");
        n.splice(o, ge((n[o + 1] || "invalid-wait").split("ms")[0]) ? 2 : 1)
    }
    if (n.includes("throttle")) {
        let o = n.indexOf("throttle");
        n.splice(o, ge((n[o + 1] || "invalid-wait").split("ms")[0]) ? 2 : 1)
    }
    if (n.length === 0 || n.length === 1 && St(e.key).includes(n[0])) return !1;
    const i = ["ctrl", "shift", "alt", "meta", "cmd", "super"].filter(o => n.includes(o));
    return n = n.filter(o => !i.includes(o)), !(i.length > 0 && i.filter(s => ((s === "cmd" || s === "super") && (s = "meta"), e[`${s}Key`])).length === i.length && (Fn(e.type) || St(e.key).includes(n[0])))
}

function St(e) {
    if (!e) return [];
    e = Di(e);
    let t = {
        ctrl: "control",
        slash: "/",
        space: " ",
        spacebar: " ",
        cmd: "meta",
        esc: "escape",
        up: "arrow-up",
        down: "arrow-down",
        left: "arrow-left",
        right: "arrow-right",
        period: ".",
        comma: ",",
        equal: "=",
        minus: "-",
        underscore: "_"
    };
    return t[e] = e, Object.keys(t).map(n => {
        if (t[n] === e) return n
    }).filter(n => n)
}
x("model", (e, {
    modifiers: t,
    expression: n
}, {
    effect: r,
    cleanup: i
}) => {
    let o = e;
    t.includes("parent") && (o = e.parentNode);
    let s = m(o, n),
        a;
    typeof n == "string" ? a = m(o, `${n} = __placeholder`) : typeof n == "function" && typeof n() == "string" ? a = m(o, `${n()} = __placeholder`) : a = () => {};
    let u = () => {
            let p;
            return s(v => p = v), At(p) ? p.get() : p
        },
        c = p => {
            let v;
            s(M => v = M), At(v) ? v.set(p) : a(() => {}, {
                scope: {
                    __placeholder: p
                }
            })
        };
    typeof n == "string" && e.type === "radio" && y(() => {
        e.hasAttribute("name") || e.setAttribute("name", n)
    });
    var l = e.tagName.toLowerCase() === "select" || ["checkbox", "radio"].includes(e.type) || t.includes("lazy") ? "change" : "input";
    let d = $ ? () => {} : We(e, l, t, p => {
        c(Ce(e, t, p, u()))
    });
    if (t.includes("fill") && ([void 0, null, ""].includes(u()) || e.type === "checkbox" && Array.isArray(u()) || e.tagName.toLowerCase() === "select" && e.multiple) && c(Ce(e, t, {
            target: e
        }, u())), e._x_removeModelListeners || (e._x_removeModelListeners = {}), e._x_removeModelListeners.default = d, i(() => e._x_removeModelListeners.default()), e.form) {
        let p = We(e.form, "reset", [], v => {
            rt(() => e._x_model && e._x_model.set(Ce(e, t, {
                target: e
            }, u())))
        });
        i(() => p())
    }
    e._x_model = {
        get() {
            return u()
        },
        set(p) {
            c(p)
        }
    }, e._x_forceModelUpdate = p => {
        p === void 0 && typeof n == "string" && n.match(/\./) && (p = ""), window.fromModel = !0, y(() => fn(e, "value", p)), delete window.fromModel
    }, r(() => {
        let p = u();
        t.includes("unintrusive") && document.activeElement.isSameNode(e) || e._x_forceModelUpdate(p)
    })
});

function Ce(e, t, n, r) {
    return y(() => {
        if (n instanceof CustomEvent && n.detail !== void 0) return n.detail !== null && n.detail !== void 0 ? n.detail : n.target.value;
        if (e.type === "checkbox")
            if (Array.isArray(r)) {
                let i = null;
                return t.includes("number") ? i = Me(n.target.value) : t.includes("boolean") ? i = de(n.target.value) : i = n.target.value, n.target.checked ? r.includes(i) ? r : r.concat([i]) : r.filter(o => !Ki(o, i))
            } else return n.target.checked;
        else {
            if (e.tagName.toLowerCase() === "select" && e.multiple) return t.includes("number") ? Array.from(n.target.selectedOptions).map(i => {
                let o = i.value || i.text;
                return Me(o)
            }) : t.includes("boolean") ? Array.from(n.target.selectedOptions).map(i => {
                let o = i.value || i.text;
                return de(o)
            }) : Array.from(n.target.selectedOptions).map(i => i.value || i.text);
            {
                let i;
                return e.type === "radio" ? n.target.checked ? i = n.target.value : i = r : i = n.target.value, t.includes("number") ? Me(i) : t.includes("boolean") ? de(i) : t.includes("trim") ? i.trim() : i
            }
        }
    })
}

function Me(e) {
    let t = e ? parseFloat(e) : null;
    return zi(t) ? t : e
}

function Ki(e, t) {
    return e == t
}

function zi(e) {
    return !Array.isArray(e) && !isNaN(e)
}

function At(e) {
    return e !== null && typeof e == "object" && typeof e.get == "function" && typeof e.set == "function"
}
x("cloak", e => queueMicrotask(() => y(() => e.removeAttribute(U("cloak")))));
rn(() => `[${U("init")}]`);
x("init", R((e, {
    expression: t
}, {
    evaluate: n
}) => typeof t == "string" ? !!t.trim() && n(t, {}, !1) : n(t, {}, !1)));
x("text", (e, {
    expression: t
}, {
    effect: n,
    evaluateLater: r
}) => {
    let i = r(t);
    n(() => {
        i(o => {
            y(() => {
                e.textContent = o
            })
        })
    })
});
x("html", (e, {
    expression: t
}, {
    effect: n,
    evaluateLater: r
}) => {
    let i = r(t);
    n(() => {
        i(o => {
            y(() => {
                e.innerHTML = o, e._x_ignoreSelf = !0, C(e), delete e._x_ignoreSelf
            })
        })
    })
});
et(Jt(":", Vt(U("bind:"))));
var Dn = (e, {
    value: t,
    modifiers: n,
    expression: r,
    original: i
}, {
    effect: o,
    cleanup: s
}) => {
    if (!t) {
        let u = {};
        Jr(u), m(e, r)(l => {
            vn(e, l, i)
        }, {
            scope: u
        });
        return
    }
    if (t === "key") return Hi(e, r);
    if (e._x_inlineBindings && e._x_inlineBindings[t] && e._x_inlineBindings[t].extract) return;
    let a = m(e, r);
    o(() => a(u => {
        u === void 0 && typeof r == "string" && r.match(/\./) && (u = ""), y(() => fn(e, t, u, n))
    })), s(() => {
        e._x_undoAddedClasses && e._x_undoAddedClasses(), e._x_undoAddedStyles && e._x_undoAddedStyles()
    })
};
Dn.inline = (e, {
    value: t,
    modifiers: n,
    expression: r
}) => {
    t && (e._x_inlineBindings || (e._x_inlineBindings = {}), e._x_inlineBindings[t] = {
        expression: r,
        extract: !1
    })
};
x("bind", Dn);

function Hi(e, t) {
    e._x_keyExpression = t
}
nn(() => `[${U("data")}]`);
x("data", (e, {
    expression: t
}, {
    cleanup: n
}) => {
    if (qi(e)) return;
    t = t === "" ? "{}" : t;
    let r = {};
    je(r, e);
    let i = {};
    Yr(i, r);
    let o = F(e, t, {
        scope: i
    });
    (o === void 0 || o === !0) && (o = {}), je(o, e);
    let s = q(o);
    Dt(s);
    let a = te(e, s);
    s.init && F(e, s.init), n(() => {
        s.destroy && F(e, s.destroy), a()
    })
});
ve((e, t) => {
    e._x_dataStack && (t._x_dataStack = e._x_dataStack, t.setAttribute("data-has-alpine-state", !0))
});

function qi(e) {
    return $ ? Ke ? !0 : e.hasAttribute("data-has-alpine-state") : !1
}
x("show", (e, {
    modifiers: t,
    expression: n
}, {
    effect: r
}) => {
    let i = m(e, n);
    e._x_doHide || (e._x_doHide = () => {
        y(() => {
            e.style.setProperty("display", "none", t.includes("important") ? "important" : void 0)
        })
    }), e._x_doShow || (e._x_doShow = () => {
        y(() => {
            e.style.length === 1 && e.style.display === "none" ? e.removeAttribute("style") : e.style.removeProperty("display")
        })
    });
    let o = () => {
            e._x_doHide(), e._x_isShown = !1
        },
        s = () => {
            e._x_doShow(), e._x_isShown = !0
        },
        a = () => setTimeout(s),
        u = Be(d => d ? s() : o(), d => {
            typeof e._x_toggleAndCascadeWithTransitions == "function" ? e._x_toggleAndCascadeWithTransitions(e, d, s, o) : d ? a() : o()
        }),
        c, l = !0;
    r(() => i(d => {
        !l && d === c || (t.includes("immediate") && (d ? a() : o()), u(d), c = d, l = !1)
    }))
});
x("for", (e, {
    expression: t
}, {
    effect: n,
    cleanup: r
}) => {
    let i = Ui(t),
        o = m(e, i.items),
        s = m(e, e._x_keyExpression || "index");
    e._x_prevKeys = [], e._x_lookup = {}, n(() => Wi(e, i, o, s)), r(() => {
        Object.values(e._x_lookup).forEach(a => a.remove()), delete e._x_prevKeys, delete e._x_lookup
    })
});

function Wi(e, t, n, r) {
    let i = s => typeof s == "object" && !Array.isArray(s),
        o = e;
    n(s => {
        Ji(s) && s >= 0 && (s = Array.from(Array(s).keys(), f => f + 1)), s === void 0 && (s = []);
        let a = e._x_lookup,
            u = e._x_prevKeys,
            c = [],
            l = [];
        if (i(s)) s = Object.entries(s).map(([f, _]) => {
            let g = Ot(t, _, f, s);
            r(b => {
                l.includes(b) && E("Duplicate key on x-for", e), l.push(b)
            }, {
                scope: {
                    index: f,
                    ...g
                }
            }), c.push(g)
        });
        else
            for (let f = 0; f < s.length; f++) {
                let _ = Ot(t, s[f], f, s);
                r(g => {
                    l.includes(g) && E("Duplicate key on x-for", e), l.push(g)
                }, {
                    scope: {
                        index: f,
                        ..._
                    }
                }), c.push(_)
            }
        let d = [],
            p = [],
            v = [],
            M = [];
        for (let f = 0; f < u.length; f++) {
            let _ = u[f];
            l.indexOf(_) === -1 && v.push(_)
        }
        u = u.filter(f => !v.includes(f));
        let oe = "template";
        for (let f = 0; f < l.length; f++) {
            let _ = l[f],
                g = u.indexOf(_);
            if (g === -1) u.splice(f, 0, _), d.push([oe, f]);
            else if (g !== f) {
                let b = u.splice(f, 1)[0],
                    w = u.splice(g - 1, 1)[0];
                u.splice(f, 0, w), u.splice(g, 0, b), p.push([b, w])
            } else M.push(_);
            oe = _
        }
        for (let f = 0; f < v.length; f++) {
            let _ = v[f];
            a[_]._x_effects && a[_]._x_effects.forEach(Ct), a[_].remove(), a[_] = null, delete a[_]
        }
        for (let f = 0; f < p.length; f++) {
            let [_, g] = p[f], b = a[_], w = a[g], K = document.createElement("div");
            y(() => {
                w || E('x-for ":key" is undefined or invalid', o, g, a), w.after(K), b.after(w), w._x_currentIfEl && w.after(w._x_currentIfEl), K.before(b), b._x_currentIfEl && b.after(b._x_currentIfEl), K.remove()
            }), w._x_refreshXForScope(c[l.indexOf(g)])
        }
        for (let f = 0; f < d.length; f++) {
            let [_, g] = d[f], b = _ === "template" ? o : a[_];
            b._x_currentIfEl && (b = b._x_currentIfEl);
            let w = c[g],
                K = l[g],
                J = document.importNode(o.content, !0).firstElementChild,
                dt = q(w);
            te(J, dt, o), J._x_refreshXForScope = Kn => {
                Object.entries(Kn).forEach(([zn, Hn]) => {
                    dt[zn] = Hn
                })
            }, y(() => {
                b.after(J), R(() => C(J))()
            }), typeof K == "object" && E("x-for key cannot be an object, it must be a string or an integer", o), a[K] = J
        }
        for (let f = 0; f < M.length; f++) a[M[f]]._x_refreshXForScope(c[l.indexOf(M[f])]);
        o._x_prevKeys = l
    })
}

function Ui(e) {
    let t = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/,
        n = /^\s*\(|\)\s*$/g,
        r = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/,
        i = e.match(r);
    if (!i) return;
    let o = {};
    o.items = i[2].trim();
    let s = i[1].replace(n, "").trim(),
        a = s.match(t);
    return a ? (o.item = s.replace(t, "").trim(), o.index = a[1].trim(), a[2] && (o.collection = a[2].trim())) : o.item = s, o
}

function Ot(e, t, n, r) {
    let i = {};
    return /^\[.*\]$/.test(e.item) && Array.isArray(t) ? e.item.replace("[", "").replace("]", "").split(",").map(s => s.trim()).forEach((s, a) => {
        i[s] = t[a]
    }) : /^\{.*\}$/.test(e.item) && !Array.isArray(t) && typeof t == "object" ? e.item.replace("{", "").replace("}", "").split(",").map(s => s.trim()).forEach(s => {
        i[s] = t[s]
    }) : i[e.item] = t, e.index && (i[e.index] = n), e.collection && (i[e.collection] = r), i
}

function Ji(e) {
    return !Array.isArray(e) && !isNaN(e)
}

function Bn() {}
Bn.inline = (e, {
    expression: t
}, {
    cleanup: n
}) => {
    let r = xe(e);
    r._x_refs || (r._x_refs = {}), r._x_refs[t] = e, n(() => delete r._x_refs[t])
};
x("ref", Bn);
x("if", (e, {
    expression: t
}, {
    effect: n,
    cleanup: r
}) => {
    e.tagName.toLowerCase() !== "template" && E("x-if can only be used on a <template> tag", e);
    let i = m(e, t),
        o = () => {
            if (e._x_currentIfEl) return e._x_currentIfEl;
            let a = e.content.cloneNode(!0).firstElementChild;
            return te(a, {}, e), y(() => {
                e.after(a), R(() => C(a))()
            }), e._x_currentIfEl = a, e._x_undoIf = () => {
                I(a, u => {
                    u._x_effects && u._x_effects.forEach(Ct)
                }), a.remove(), delete e._x_currentIfEl
            }, a
        },
        s = () => {
            e._x_undoIf && (e._x_undoIf(), delete e._x_undoIf)
        };
    n(() => i(a => {
        a ? o() : s()
    })), r(() => e._x_undoIf && e._x_undoIf())
});
x("id", (e, {
    expression: t
}, {
    evaluate: n
}) => {
    n(t).forEach(i => Ri(e, i))
});
ve((e, t) => {
    e._x_ids && (t._x_ids = e._x_ids)
});
et(Jt("@", Vt(U("on:"))));
x("on", R((e, {
    value: t,
    modifiers: n,
    expression: r
}, {
    cleanup: i
}) => {
    let o = r ? m(e, r) : () => {};
    e.tagName.toLowerCase() === "template" && (e._x_forwardEvents || (e._x_forwardEvents = []), e._x_forwardEvents.includes(t) || e._x_forwardEvents.push(t));
    let s = We(e, t, n, a => {
        o(() => {}, {
            scope: {
                $event: a
            },
            params: [a]
        })
    });
    i(() => s())
}));
Ee("Collapse", "collapse", "collapse");
Ee("Intersect", "intersect", "intersect");
Ee("Focus", "trap", "focus");
Ee("Mask", "mask", "mask");

function Ee(e, t, n) {
    x(t, r => E(`You can't use [x-${t}] without first installing the "${e}" plugin here: https://alpinejs.dev/plugins/${n}`, r))
}
ie.setEvaluator(Ht);
ie.setReactivityEngine({
    reactive: ft,
    effect: oi,
    release: si,
    raw: h
});
var Vi = ie,
    kn = Vi;
window.Alpine = kn;
kn.start();