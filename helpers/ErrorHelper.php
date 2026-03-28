<?php

namespace helpers;

class ErrorHelper
{
    public const array errors = [
        400 => [
            "code" => 400,
            "error" => "Bad Request",
            "description" => "The server can’t process your request. Client-side error. Invalid syntax. Bad routing. Wrong parameters."
        ],
        401 => [
            "code" => 401,
            "error" => "Unauthorized",
            "description" => "The server rejected your request due to missing or invalid authentication. Log in with valid credentials."
        ],
        402 => [
            "code" => 402,
            "error" => "Payment Required",
            "description" => "Reserved for digital payment systems but rarely used. No clear implementation rules exist."
        ],
        403 => [
            "code" => 403,
            "error" => "Forbidden",
            "description" => "The server understood your request but denied access. Usually due to insufficient permissions. Re-authentication won’t help."
        ],
        404 => [
            "code" => 404,
            "error" => "Not Found",
            "description" => "The server can’t find the requested resource. Broken links or non-existent endpoints."
        ],
        405 => [
            "code" => 405,
            "error" => "Method Not Allowed",
            "description" => "The server recognizes the request method but the resource doesn’t support it."
        ],
        406 => [
            "code" => 406,
            "error" => "Not Acceptable",
            "description" => "The server can’t find content matching the criteria in your Accept headers."
        ],
        407 => [
            "code" => 407,
            "error" => "Proxy Authentication Required",
            "description" => "You’re using a proxy and need valid authentication with the proxy server."
        ],
        408 => [
            "code" => 408,
            "error" => "Request Timeout",
            "description" => "The server didn’t receive the complete request within the allowed time."
        ],
        409 => [
            "code" => 409,
            "error" => "Conflict",
            "description" => "The server can’t process the request due to a conflict with the resource."
        ],
        410 => [
            "code" => 410,
            "error" => "Gone",
            "description" => "The resource permanently disappeared. No forwarding address."
        ],
        411 => [
            "code" => 411,
            "error" => "Length Required",
            "description" => "The server rejected the request because it needs a Content-Length header."
        ],
        412 => [
            "code" => 412,
            "error" => "Precondition Failed",
            "description" => "The server couldn’t meet one or more conditions in the request headers."
        ],
        413 => [
            "code" => 413,
            "error" => "Payload Too Large",
            "description" => "Your request is too large to process. The server might close the connection."
        ],
        414 => [
            "code" => 414,
            "error" => "URI Too Long",
            "description" => "The request URI exceeds what the server can handle."
        ],
        415 => [
            "code" => 415,
            "error" => "Unsupported Media Type",
            "description" => "The server rejected the request because the resource uses an unsupported media format."
        ],
        416 => [
            "code" => 416,
            "error" => "Range Not Satisfiable",
            "description" => "The server can’t process the range in your request. The range doesn’t exist or is invalid."
        ],
        417 => [
            "code" => 417,
            "error" => "Expectation Failed",
            "description" => "The server can’t meet the requirements in the request’s Expect header."
        ],
        418 => [
            "code" => 418,
            "error" => "I’m a Teapot",
            "description" => "An April Fools’ joke; the server’s a teapot and can’t brew coffee."
        ],
        421 => [
            "code" => 421,
            "error" => "Misdirected Request",
            "description" => "The client sent a request to the wrong server. Retry with a different connection."
        ],
        422 => [
            "code" => 422,
            "error" => "Unprocessable Entity",
            "description" => "The request was received but cannot be processed due to semantic errors."
        ],
        423 => [
            "code" => 423,
            "error" => "Locked",
            "description" => "The resource is locked. The response includes details about the lock status."
        ],
        424 => [
            "code" => 424,
            "error" => "Failed Dependency",
            "description" => "The request failed because it depended on a previous request that also failed."
        ],
        425 => [
            "code" => 425,
            "error" => "Too Early",
            "description" => "The server refuses to process the request because it might be replayed later."
        ],
        426 => [
            "code" => 426,
            "error" => "Upgrade Required",
            "description" => "The server won’t process the request unless the client switches to the required protocol."
        ],
        428 => [
            "code" => 428,
            "error" => "Precondition Required",
            "description" => "The server needs a conditional request to ensure the client’s using the correct version."
        ],
        429 => [
            "code" => 429,
            "error" => "Too Many Requests",
            "description" => "You sent too many requests in a short time. Rate limited."
        ],
        431 => [
            "code" => 431,
            "error" => "Request Header Fields Too Large",
            "description" => "Your request headers are too big to process. Reduce header size and resend."
        ],
        451 => [
            "code" => 451,
            "error" => "Unavailable for Legal Reasons",
            "description" => "The resource was removed due to legal reasons. Site blocked or page taken down."
        ],
        500 => [
            "code" => 500,
            "error" => "Internal Server Error",
            "description" => "Generic error. The server hit an unexpected problem that prevented it from completing the request."
        ],
        501 => [
            "code" => 501,
            "error" => "Not Implemented",
            "description" => "The server doesn’t support the functionality needed to complete the request."
        ],
        502 => [
            "code" => 502,
            "error" => "Bad Gateway",
            "description" => "The gateway or proxy server received an invalid response while trying to complete the request."
        ],
        503 => [
            "code" => 503,
            "error" => "Service Unavailable",
            "description" => "The server can’t handle the request due to temporary overload or maintenance."
        ],
        504 => [
            "code" => 504,
            "error" => "Gateway Timeout",
            "description" => "The gateway or proxy server didn’t get a timely response from the upstream server."
        ],
        505 => [
            "code" => 505,
            "error" => "HTTP Version Not Supported",
            "description" => "The server doesn’t support the HTTP version used in the request."
        ],
        506 => [
            "code" => 506,
            "error" => "Variant Also Negotiates",
            "description" => "Server configuration error. The chosen resource variant creates an infinite loop."
        ],
        507 => [
            "code" => 507,
            "error" => "Insufficient Storage",
            "description" => "The server doesn’t have enough storage to complete the request. Disk full."
        ],
        508 => [
            "code" => 508,
            "error" => "Loop Detected",
            "description" => "The server stopped an operation because it detected an infinite loop."
        ],
        510 => [
            "code" => 510,
            "error" => "Not Extended",
            "description" => "The server needs further extensions to complete the request."
        ],
        511 => [
            "code" => 511,
            "error" => "Network Authentication Required",
            "description" => "You need to authenticate to access the network. Common with captive portals."
        ]
    ];
}