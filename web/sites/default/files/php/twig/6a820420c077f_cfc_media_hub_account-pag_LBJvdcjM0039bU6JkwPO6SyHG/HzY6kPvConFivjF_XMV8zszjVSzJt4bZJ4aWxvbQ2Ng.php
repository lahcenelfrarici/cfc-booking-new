<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:account-page */
class __TwigTemplate_e9cda54c9a8903cb102502ee895d8ad7 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--account-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:account-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:account-page"));
        $context["space_icons"] = ["studio" => "mic", "meeting" => "users", "desk" => "monitor"];
        // line 2
        $context["status_classes"] = ["upcoming" => "bg-[#E1F5EE] text-[#0F6E56]", "completed" => "bg-neutral-100 text-neutral-600", "cancelled" => "bg-[#9F5434]/10 text-[#9F5434]"];
        // line 3
        $context["status_icons"] = ["upcoming" => "clock", "completed" => "check-check", "cancelled" => "x"];
        // line 4
        $context["status_labels"] = ["upcoming" => "Upcoming", "completed" => "Completed", "cancelled" => "Cancelled"];
        // line 5
        yield "
";
        // line 6
        $context["upcoming_count"] = 0;
        // line 7
        $context["completed_count"] = 0;
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["reservations"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["r"]) {
            // line 9
            yield "  ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 9) == "upcoming")) {
                $context["upcoming_count"] = (($context["upcoming_count"] ?? null) + 1);
            }
            // line 10
            yield "  ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 10) == "completed")) {
                $context["completed_count"] = (($context["completed_count"] ?? null) + 1);
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['r'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 12
        yield "
<div>

  ";
        // line 16
        yield "  <section class=\"bg-white pt-16 pb-14 border-b border-neutral-100\">
    <div class=\"max-w-[1440px] mx-auto px-12\">
      <div class=\"flex items-center gap-2 text-[12px] text-neutral-500 mb-10\">
        <a href=\"";
        // line 19
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"hover:text-neutral-900 transition-colors\">Home</a>
        <span>/</span>
        <span class=\"text-neutral-900\">My Account</span>
      </div>

      <div class=\"flex items-start justify-between gap-12\">
        <div>
          <div class=\"flex items-center gap-3 mb-4\">
            <div class=\"w-5 h-[2px] bg-[#9F5434]\"></div>
            <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#9F5434] font-semibold\">My Account</div>
          </div>
          <h1 class=\"tracking-tight text-neutral-900 mb-2\" style=\"font-size: 52px; font-weight: 600; line-height: 1.05; letter-spacing: -0.025em;\">
            Welcome back, ";
        // line 31
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_name"] ?? null), "html", null, true);
        yield ".
          </h1>
          <div class=\"flex items-center gap-2 mb-5\">
            ";
        // line 34
        yield from $this->load("cfc_media_hub:icon", 34)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-4 h-4 text-[#0F6E56]"]));
        // line 35
        yield "            <span class=\"text-[14px] text-[#0F6E56] font-medium\">";
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_email"] ?? null), "html", null, true);
        yield "</span>
          </div>
          <p class=\"text-neutral-500 max-w-[480px] text-[15px]\">
            Manage your reservations, digital access card and account information.
          </p>
        </div>

        <div class=\"shrink-0 flex flex-col items-center gap-3 pt-2\">
          <div class=\"w-20 h-20 rounded-full bg-[#9F5434]/10 border-2 border-[#9F5434]/20 flex items-center justify-center\">
            <span class=\"text-[#9F5434]\" style=\"font-size: 24px; font-weight: 700;\">";
        // line 44
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_initials"] ?? null), "html", null, true);
        yield "</span>
          </div>
          <div class=\"text-center\">
            <div class=\"text-[13px] text-neutral-900 font-semibold\">";
        // line 47
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_name"] ?? null), "html", null, true);
        yield "</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  ";
        // line 55
        yield "  <section class=\"bg-[#FCFCFB] py-10 border-b border-neutral-100\">
    <div class=\"max-w-[1440px] mx-auto px-12\">
      <div class=\"grid grid-cols-3 gap-5\">
        <div class=\"bg-white border border-neutral-200/70 rounded-2xl p-6 flex items-start gap-4\">
          <div class=\"w-11 h-11 rounded-xl bg-[#E1F5EE]/60 flex items-center justify-center shrink-0 text-[#0F6E56]\">
            ";
        // line 60
        yield from $this->load("cfc_media_hub:icon", 60)->unwrap()->yield(CoreExtension::toArray(["name" => "calendar", "size" => "w-5 h-5"]));
        // line 61
        yield "          </div>
          <div>
            <div class=\"text-[12px] text-neutral-500 mb-1 uppercase tracking-wide font-semibold\">Upcoming Reservations</div>
            <div class=\"text-[15px] text-[#0F6E56] font-bold\">";
        // line 64
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["upcoming_count"] ?? null), "html", null, true);
        yield " Upcoming</div>
          </div>
        </div>
        <div class=\"bg-white border border-neutral-200/70 rounded-2xl p-6 flex items-start gap-4\">
          <div class=\"w-11 h-11 rounded-xl bg-neutral-50 flex items-center justify-center shrink-0 text-neutral-600\">
            ";
        // line 69
        yield from $this->load("cfc_media_hub:icon", 69)->unwrap()->yield(CoreExtension::toArray(["name" => "check-check", "size" => "w-5 h-5"]));
        // line 70
        yield "          </div>
          <div>
            <div class=\"text-[12px] text-neutral-500 mb-1 uppercase tracking-wide font-semibold\">Reservation History</div>
            <div class=\"text-[15px] text-neutral-600 font-bold\">";
        // line 73
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["completed_count"] ?? null), "html", null, true);
        yield " Completed</div>
          </div>
        </div>
        <div class=\"bg-white border border-neutral-200/70 rounded-2xl p-6 flex items-start gap-4\">
          <div class=\"w-11 h-11 rounded-xl bg-[#E1F5EE]/60 flex items-center justify-center shrink-0 text-[#0F6E56]\">
            ";
        // line 78
        yield from $this->load("cfc_media_hub:icon", 78)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-5 h-5 text-[#0F6E56]"]));
        // line 79
        yield "          </div>
          <div>
            <div class=\"text-[12px] text-neutral-500 mb-1 uppercase tracking-wide font-semibold\">Account Status</div>
            <div class=\"text-[15px] text-[#0F6E56] font-bold\">Registered user</div>
            <div class=\"mt-1.5 inline-flex items-center gap-1 bg-[#9F5434] text-white px-2 py-0.5 rounded-full text-[10px] font-semibold\">
              ";
        // line 84
        yield from $this->load("cfc_media_hub:icon", 84)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-2.5 h-2.5"]));
        yield " Verified
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  ";
        // line 93
        yield "  <section class=\"bg-white py-12\">
    <div class=\"max-w-[1440px] mx-auto px-12\">
      <div class=\"flex items-end justify-between mb-10\">
        <div>
          <div class=\"flex items-center gap-3 mb-3\">
            <div class=\"w-4 h-[2px] bg-[#9F5434]\"></div>
            <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#9F5434] font-semibold\">Reservations</div>
          </div>
          <h2 class=\"tracking-tight text-neutral-900\" style=\"font-size: 36px; font-weight: 600; letter-spacing: -0.02em;\">My reservations</h2>
        </div>
        <a href=\"";
        // line 103
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["booking_base_url"] ?? null), "html", null, true);
        yield "\" class=\"flex items-center gap-2 bg-[#9F5434] hover:bg-[#8A4A2E] text-white px-6 py-3 rounded-xl text-[13px] transition-colors group font-semibold\">
          New reservation
          ";
        // line 105
        yield from $this->load("cfc_media_hub:icon", 105)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4", "class" => "group-hover:translate-x-0.5 transition-transform"]));
        // line 106
        yield "        </a>
      </div>

      <div class=\"space-y-4\">
        ";
        // line 110
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["reservations"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["r"]) {
            // line 111
            yield "          <div class=\"bg-white border rounded-2xl p-7 transition-all ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 111) == "upcoming")) ? ("border-neutral-200/70 shadow-[0_4px_20px_-8px_rgba(0,0,0,0.08)]") : ("border-neutral-200/50 opacity-85")));
            yield "\">
            <div class=\"flex items-start justify-between gap-6\">
              <div class=\"flex items-start gap-4\">
                <div class=\"w-11 h-11 rounded-xl flex items-center justify-center shrink-0 ";
            // line 114
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 114) == "studio")) ? ("bg-[#9F5434]/10 text-[#9F5434]") : ("bg-neutral-100 text-neutral-600")));
            yield "\">
                  ";
            // line 115
            yield from $this->load("cfc_media_hub:icon", 115)->unwrap()->yield(CoreExtension::toArray(["name" => (((CoreExtension::getAttribute($this->env, $this->source, ($context["space_icons"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 115), [], "array", true, true, true, 115) &&  !(null === (($_v0 = ($context["space_icons"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess && in_array($_v0::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v0[(($_v1 = CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 115)) instanceof \Stringable ? (string) $_v1 : $_v1)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["space_icons"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 115), [], "array", false, false, true, 115))))) ? ((($_v2 = ($context["space_icons"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess && in_array($_v2::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v2[(($_v3 = CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 115)) instanceof \Stringable ? (string) $_v3 : $_v3)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["space_icons"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 115), [], "array", false, false, true, 115))) : ("monitor")), "size" => "w-4 h-4"]));
            // line 116
            yield "                </div>
                <div>
                  <div class=\"flex items-center gap-3 mb-1\">
                    <h3 class=\"tracking-tight text-neutral-900\" style=\"font-size: 18px; font-weight: 600;\">";
            // line 119
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space", [], "any", false, false, true, 119), "html", null, true);
            yield "</h3>
                    <span class=\"inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold ";
            // line 120
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($_v4 = ($context["status_classes"] ?? null)) && is_array($_v4) || $_v4 instanceof ArrayAccess && in_array($_v4::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v4[(($_v5 = CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 120)) instanceof \Stringable ? (string) $_v5 : $_v5)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["status_classes"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 120), [], "array", false, false, true, 120)), "html", null, true);
            yield "\">
                      ";
            // line 121
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($_v6 = ($context["status_labels"] ?? null)) && is_array($_v6) || $_v6 instanceof ArrayAccess && in_array($_v6::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v6[(($_v7 = CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 121)) instanceof \Stringable ? (string) $_v7 : $_v7)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["status_labels"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 121), [], "array", false, false, true, 121)), "html", null, true);
            yield "
                    </span>
                  </div>
                  <div class=\"text-[13px] text-neutral-500 space-x-3\">
                    <span>";
            // line 125
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "id", [], "any", false, false, true, 125), "html", null, true);
            yield "</span>
                    <span>&middot;</span>
                    <span>";
            // line 127
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "price", [], "any", false, false, true, 127), "html", null, true);
            yield "</span>
                  </div>
                </div>
              </div>

              <div class=\"flex items-center gap-2 shrink-0\">
                ";
            // line 133
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 133) == "upcoming")) {
                // line 134
                yield "                  <a href=\"";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "cancel_url", [], "any", false, false, true, 134), "html", null, true);
                yield "\" class=\"px-4 py-2 border border-neutral-200 hover:border-[#9F5434]/40 hover:text-[#9F5434] text-neutral-600 rounded-xl text-[13px] transition-colors font-medium\">Cancel</a>
                ";
            }
            // line 136
            yield "              </div>
            </div>

            <div class=\"mt-5 pt-5 border-t border-neutral-100 grid grid-cols-3 gap-6\">
              <div>
                <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">Date</div>
                <div class=\"text-[14px] text-neutral-800 font-medium\">";
            // line 142
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "date", [], "any", false, false, true, 142), "html", null, true);
            yield "</div>
              </div>
              <div>
                <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">Time</div>
                <div class=\"text-[14px] text-neutral-800 font-medium\">";
            // line 146
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "time", [], "any", false, false, true, 146), "html", null, true);
            yield "</div>
              </div>
              <div>
                <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">Duration</div>
                <div class=\"text-[14px] text-neutral-800 font-medium\">";
            // line 150
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "duration", [], "any", false, false, true, 150), "html", null, true);
            yield "</div>
              </div>
            </div>
          </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['r'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 155
        yield "      </div>

      <p class=\"mt-6 text-[12px] text-neutral-400 flex items-start gap-2\">
        ";
        // line 158
        yield from $this->load("cfc_media_hub:icon", 158)->unwrap()->yield(CoreExtension::toArray(["name" => "alert-circle", "size" => "w-3.5 h-3.5 text-[#9F5434] shrink-0 mt-0.5"]));
        // line 159
        yield "        Reservations may be cancelled according to the applicable booking policy.
      </p>
    </div>
  </section>

  ";
        // line 165
        yield "  <section class=\"bg-[#FCFCFB] py-12 border-t border-b border-neutral-100\">
    <div class=\"max-w-[1440px] mx-auto px-12\">
      <div class=\"grid grid-cols-12 gap-12 items-start\">
        <div class=\"col-span-5\">
          <div class=\"flex items-center gap-3 mb-4\">
            <div class=\"w-4 h-[2px] bg-[#9F5434]\"></div>
            <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#9F5434] font-semibold\">Digital Access Card</div>
          </div>
          <h2 class=\"tracking-tight text-neutral-900 mb-4\" style=\"font-size: 36px; font-weight: 600; letter-spacing: -0.02em;\">Your access card.</h2>
          <p class=\"text-neutral-500 leading-relaxed mb-8 text-[15px]\">
            Present this QR code at reception for a quick and seamless check-in. Your card is linked to your accreditation and active reservations.
          </p>
          <div class=\"space-y-3 text-[14px] text-neutral-600\">
            <div class=\"flex items-center gap-2\">
              ";
        // line 179
        yield from $this->load("cfc_media_hub:icon", 179)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-4 h-4 text-[#0F6E56] shrink-0"]));
        // line 180
        yield "              Valid for all reserved spaces
            </div>
            <div class=\"flex items-center gap-2\">
              ";
        // line 183
        yield from $this->load("cfc_media_hub:icon", 183)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-4 h-4 text-[#0F6E56] shrink-0"]));
        // line 184
        yield "              Linked to your press accreditation
            </div>
            <div class=\"flex items-center gap-2\">
              ";
        // line 187
        yield from $this->load("cfc_media_hub:icon", 187)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-4 h-4 text-[#0F6E56] shrink-0"]));
        // line 188
        yield "              Refreshed automatically for each session
            </div>
          </div>
        </div>

        <div class=\"col-span-7\">
          <div class=\"relative\">
            <div class=\"absolute -inset-4 bg-[#9F5434]/10 rounded-[36px] blur-2xl\"></div>
            <div class=\"relative bg-neutral-950 rounded-3xl overflow-hidden shadow-[0_40px_80px_-20px_rgba(0,0,0,0.5)]\">
              <div class=\"h-1 bg-gradient-to-r from-[#9F5434] via-[#C27048] to-[#9F5434]\"></div>

              <div class=\"p-8\">
                <div class=\"flex items-center justify-between mb-8\">
                  <div>
                    <div class=\"text-[11px] uppercase tracking-[0.2em] text-[#9F5434] font-bold\">CFC Media Hub</div>
                    <div class=\"text-white/50 text-[11px] mt-0.5\">Casablanca Finance City &middot; Morocco</div>
                  </div>
                  <div class=\"w-8 h-8 rounded-full border border-[#9F5434]/40 flex items-center justify-center\">
                    <div class=\"w-3 h-3 rounded-full bg-[#9F5434]\"></div>
                  </div>
                </div>

                <div class=\"flex items-start justify-between gap-8\">
                  <div class=\"flex-1\">
                    <div class=\"w-16 h-16 rounded-full bg-[#9F5434]/20 border border-[#9F5434]/30 flex items-center justify-center mb-5\">
                      <span class=\"text-[#9F5434]\" style=\"font-size: 20px; font-weight: 700;\">";
        // line 213
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_initials"] ?? null), "html", null, true);
        yield "</span>
                    </div>

                    <div class=\"text-white\" style=\"font-size: 22px; font-weight: 600; letter-spacing: -0.02em;\">";
        // line 216
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_name"] ?? null), "html", null, true);
        yield "</div>
                    <div class=\"text-white/40 text-[12px] mt-0.5\">";
        // line 217
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_email"] ?? null), "html", null, true);
        yield "</div>

                    <div class=\"mt-6 pt-5 border-t border-white/10\">
                      <div class=\"text-[10px] uppercase tracking-[0.16em] text-white/40 mb-1.5 font-semibold\">Valid Until</div>
                      <div class=\"text-white/80 text-[13px] font-medium\">31 December 2026</div>
                    </div>
                  </div>

                  <div class=\"shrink-0 flex flex-col items-center gap-3\">
                    <div class=\"p-3 bg-white rounded-2xl shadow-[0_8px_24px_rgba(0,0,0,0.3)]\">
                      ";
        // line 227
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["qr_svg"] ?? null));
        yield "
                    </div>
                    <div class=\"text-[11px] text-white/40 text-center max-w-[160px] leading-relaxed\">
                      Present at reception for check-in
                    </div>
                  </div>
                </div>
              </div>

              <div class=\"px-8 py-4 bg-[#9F5434]/8 border-t border-white/[0.06] flex items-center justify-between\">
                <div class=\"text-[11px] text-white/30\">Verified &middot; CFC Media Hub Platform</div>
                <div class=\"flex items-center gap-1.5\">
                  <div class=\"w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse\"></div>
                  <span class=\"text-[11px] text-white/40\">Active</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  ";
        // line 251
        yield "  <section class=\"bg-white py-12\">
    <div class=\"max-w-[1440px] mx-auto px-12\">
      <div class=\"grid grid-cols-2 gap-8\">
        <div class=\"bg-[#FCFCFB] border border-neutral-200/70 rounded-3xl p-8\">
          <div class=\"flex items-center gap-3 mb-6\">
            <div class=\"w-10 h-10 rounded-xl bg-[#9F5434]/10 text-[#9F5434] flex items-center justify-center shrink-0\">
              ";
        // line 257
        yield from $this->load("cfc_media_hub:icon", 257)->unwrap()->yield(CoreExtension::toArray(["name" => "alert-circle", "size" => "w-5 h-5"]));
        // line 258
        yield "            </div>
            <h3 class=\"tracking-tight text-neutral-900\" style=\"font-size: 20px; font-weight: 600; letter-spacing: -0.01em;\">Studio booking information</h3>
          </div>
          <div class=\"space-y-4\">
            <div class=\"flex items-start gap-3 text-[14px] text-neutral-700 leading-relaxed\">
              <span class=\"shrink-0 mt-0.5\">";
        // line 263
        yield from $this->load("cfc_media_hub:icon", 263)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-4 h-4 text-[#0F6E56]"]));
        yield "</span>
              Only the Podcast Studio is subject to a fee.
            </div>
            <div class=\"flex items-start gap-3 text-[14px] text-neutral-700 leading-relaxed\">
              <span class=\"shrink-0 mt-0.5\">";
        // line 267
        yield from $this->load("cfc_media_hub:icon", 267)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-4 h-4 text-[#0F6E56]"]));
        yield "</span>
              Meeting Rooms and Desks are available free of charge for International Accredited Journalists.
            </div>
            <div class=\"mt-5 pt-5 border-t border-neutral-200 rounded-2xl bg-[#9F5434]/5 p-5 -mx-1\">
              <div class=\"text-[12px] uppercase tracking-[0.14em] text-[#9F5434] mb-3 font-bold\">CFC Member Companies</div>
              <div class=\"text-[14px] text-neutral-700 leading-relaxed\">
                CFC Member Companies have access exclusively to the Podcast Studio. Meeting Rooms and Desks are not available.
              </div>
            </div>
          </div>
        </div>

        <div class=\"bg-[#FCFCFB] border border-neutral-200/70 rounded-3xl p-8\">
          <div class=\"flex items-center gap-3 mb-6\">
            <div class=\"w-10 h-10 rounded-xl bg-[#9F5434]/10 text-[#9F5434] flex items-center justify-center shrink-0\">
              ";
        // line 282
        yield from $this->load("cfc_media_hub:icon", 282)->unwrap()->yield(CoreExtension::toArray(["name" => "file-text", "size" => "w-5 h-5"]));
        // line 283
        yield "            </div>
            <h3 class=\"tracking-tight text-neutral-900\" style=\"font-size: 20px; font-weight: 600; letter-spacing: -0.01em;\">Studio deliverables</h3>
          </div>
          <ul class=\"space-y-4\">
            ";
        // line 287
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(["Raw footage is delivered without editing.", "Recordings between 1 and 2 hours are delivered the same day.", "Half-day recordings are delivered within a maximum of 24 hours.", "Files are delivered via WeTransfer or on the client\x27s hard drive."]);
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["d"]) {
            // line 293
            yield "              <li class=\"flex items-start gap-3 text-[14px] text-neutral-700 leading-relaxed\">
                <span class=\"w-5 h-5 rounded-full bg-[#9F5434]/10 text-[#9F5434] flex items-center justify-center shrink-0 mt-0.5 text-[10px] font-bold\">";
            // line 294
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 294), "html", null, true);
            yield "</span>
                ";
            // line 295
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["d"], "html", null, true);
            yield "
              </li>
            ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['d'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 298
        yield "          </ul>
        </div>
      </div>
    </div>
  </section>

  ";
        // line 305
        yield "  <section class=\"bg-[#FCFCFB] py-12 border-t border-neutral-100\">
    <div class=\"max-w-[1440px] mx-auto px-12\">
      <div class=\"flex items-center gap-3 mb-8\">
        <div class=\"w-4 h-[2px] bg-[#9F5434]\"></div>
        <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#9F5434] font-semibold\">History</div>
      </div>
      <h2 class=\"tracking-tight text-neutral-900 mb-8\" style=\"font-size: 36px; font-weight: 600; letter-spacing: -0.02em;\">Reservation history</h2>

      <div class=\"bg-white border border-neutral-200/70 rounded-2xl overflow-hidden\">
        <div class=\"grid grid-cols-12 gap-4 px-7 py-4 border-b border-neutral-100 bg-neutral-50\">
          <div class=\"col-span-1 text-[11px] uppercase tracking-wide text-neutral-400 font-semibold\">#</div>
          <div class=\"col-span-4 text-[11px] uppercase tracking-wide text-neutral-400 font-semibold\">Reservation</div>
          <div class=\"col-span-3 text-[11px] uppercase tracking-wide text-neutral-400 font-semibold\">Date</div>
          <div class=\"col-span-2 text-[11px] uppercase tracking-wide text-neutral-400 font-semibold\">Status</div>
          <div class=\"col-span-2 text-[11px] uppercase tracking-wide text-neutral-400 text-right font-semibold\">Action</div>
        </div>

        ";
        // line 322
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["reservations"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["r"]) {
            // line 323
            yield "          <div class=\"grid grid-cols-12 gap-4 px-7 py-5 items-center hover:bg-neutral-50/60 transition-colors ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((( !(($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, true, 323)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("border-b border-neutral-100") : ("")));
            yield "\">
            <div class=\"col-span-1 text-[12px] text-neutral-400 font-semibold\">0";
            // line 324
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 324), "html", null, true);
            yield "</div>
            <div class=\"col-span-4\">
              <div class=\"flex items-center gap-2.5\">
                <div class=\"w-8 h-8 rounded-lg flex items-center justify-center ";
            // line 327
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 327) == "studio")) ? ("bg-[#9F5434]/10 text-[#9F5434]") : ("bg-neutral-100 text-neutral-500")));
            yield "\">
                  ";
            // line 328
            yield from $this->load("cfc_media_hub:icon", 328)->unwrap()->yield(CoreExtension::toArray(["name" => (((CoreExtension::getAttribute($this->env, $this->source, ($context["space_icons"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 328), [], "array", true, true, true, 328) &&  !(null === (($_v8 = ($context["space_icons"] ?? null)) && is_array($_v8) || $_v8 instanceof ArrayAccess && in_array($_v8::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v8[(($_v9 = CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 328)) instanceof \Stringable ? (string) $_v9 : $_v9)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["space_icons"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 328), [], "array", false, false, true, 328))))) ? ((($_v10 = ($context["space_icons"] ?? null)) && is_array($_v10) || $_v10 instanceof ArrayAccess && in_array($_v10::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v10[(($_v11 = CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 328)) instanceof \Stringable ? (string) $_v11 : $_v11)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["space_icons"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space_key", [], "any", false, false, true, 328), [], "array", false, false, true, 328))) : ("monitor")), "size" => "w-4 h-4"]));
            // line 329
            yield "                </div>
                <div>
                  <div class=\"text-[14px] text-neutral-900 font-semibold\">";
            // line 331
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "space", [], "any", false, false, true, 331), "html", null, true);
            yield "</div>
                  <div class=\"text-[11px] text-neutral-400\">";
            // line 332
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "id", [], "any", false, false, true, 332), "html", null, true);
            yield "</div>
                </div>
              </div>
            </div>
            <div class=\"col-span-3 text-[13px] text-neutral-600\">";
            // line 336
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["r"], "date", [], "any", false, false, true, 336), "html", null, true);
            yield "</div>
            <div class=\"col-span-2\">
              <span class=\"inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold ";
            // line 338
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($_v12 = ($context["status_classes"] ?? null)) && is_array($_v12) || $_v12 instanceof ArrayAccess && in_array($_v12::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v12[(($_v13 = CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 338)) instanceof \Stringable ? (string) $_v13 : $_v13)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["status_classes"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 338), [], "array", false, false, true, 338)), "html", null, true);
            yield "\">
                ";
            // line 339
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($_v14 = ($context["status_labels"] ?? null)) && is_array($_v14) || $_v14 instanceof ArrayAccess && in_array($_v14::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v14[(($_v15 = CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 339)) instanceof \Stringable ? (string) $_v15 : $_v15)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["status_labels"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["r"], "status", [], "any", false, false, true, 339), [], "array", false, false, true, 339)), "html", null, true);
            yield "
              </span>
            </div>
            <div class=\"col-span-2 text-right\"></div>
          </div>
        ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['r'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 345
        yield "      </div>
    </div>
  </section>

  ";
        // line 350
        yield "  <section class=\"bg-white py-12 border-t border-neutral-100\">
    <div class=\"max-w-[1440px] mx-auto px-12\">
      <div class=\"flex items-center gap-3 mb-8\">
        <div class=\"w-4 h-[2px] bg-[#9F5434]\"></div>
        <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#9F5434] font-semibold\">Settings</div>
      </div>
      <h2 class=\"tracking-tight text-neutral-900 mb-8\" style=\"font-size: 36px; font-weight: 600; letter-spacing: -0.02em;\">Account settings</h2>

      <div class=\"grid grid-cols-2 gap-4 mb-4\">
        ";
        // line 359
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable([["icon" => "edit-2", "label" => "Edit profile", "desc" => "Update your personal information and credentials."], ["icon" => "lock", "label" => "Change password", "desc" => "Update your account password and security settings."], ["icon" => "bell", "label" => "Notification preferences", "desc" => "Manage email and platform notification settings."], ["icon" => "shield", "label" => "Privacy & security", "desc" => "Control your data, access and privacy options."]]);
        foreach ($context['_seq'] as $context["_key"] => $context["s"]) {
            // line 365
            yield "          <button type=\"button\" class=\"flex items-center gap-4 bg-[#FCFCFB] border border-neutral-200/70 hover:border-[#9F5434]/30 hover:shadow-[0_8px_24px_-8px_rgba(159,84,52,0.1)] rounded-2xl p-6 text-left transition-all group\">
            <div class=\"w-10 h-10 rounded-xl bg-[#9F5434]/10 text-[#9F5434] flex items-center justify-center shrink-0 group-hover:bg-[#9F5434] group-hover:text-white transition-colors\">
              ";
            // line 367
            yield from $this->load("cfc_media_hub:icon", 367)->unwrap()->yield(CoreExtension::toArray(["name" => CoreExtension::getAttribute($this->env, $this->source, $context["s"], "icon", [], "any", false, false, true, 367), "size" => "w-4 h-4"]));
            // line 368
            yield "            </div>
            <div class=\"flex-1\">
              <div class=\"text-[15px] text-neutral-900 mb-0.5 font-semibold\">";
            // line 370
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "label", [], "any", false, false, true, 370), "html", null, true);
            yield "</div>
              <div class=\"text-[13px] text-neutral-500 leading-relaxed\">";
            // line 371
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "desc", [], "any", false, false, true, 371), "html", null, true);
            yield "</div>
            </div>
            ";
            // line 373
            yield from $this->load("cfc_media_hub:icon", 373)->unwrap()->yield(CoreExtension::toArray(["name" => "chevron-right", "size" => "w-4 h-4 text-neutral-300 group-hover:text-[#9F5434] transition-colors shrink-0"]));
            // line 374
            yield "          </button>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['s'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 376
        yield "      </div>

      <a href=\"";
        // line 378
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["logout_url"] ?? null), "html", null, true);
        yield "\" class=\"w-full flex items-center gap-4 border border-[#9F5434]/20 hover:border-[#9F5434]/50 hover:bg-[#9F5434]/5 rounded-2xl p-6 text-left transition-all group\">
        <div class=\"w-10 h-10 rounded-xl bg-[#9F5434]/10 text-[#9F5434] flex items-center justify-center shrink-0\">
          ";
        // line 380
        yield from $this->load("cfc_media_hub:icon", 380)->unwrap()->yield(CoreExtension::toArray(["name" => "log-out", "size" => "w-4 h-4"]));
        // line 381
        yield "        </div>
        <div class=\"flex-1\">
          <div class=\"text-[15px] text-[#9F5434] font-semibold\">Log out</div>
          <div class=\"text-[13px] text-neutral-400\">Sign out of your CFC Media Hub account.</div>
        </div>
        ";
        // line 386
        yield from $this->load("cfc_media_hub:icon", 386)->unwrap()->yield(CoreExtension::toArray(["name" => "chevron-right", "size" => "w-4 h-4 text-[#9F5434]/40 group-hover:text-[#9F5434] transition-colors shrink-0"]));
        // line 387
        yield "      </a>
    </div>
  </section>

</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["reservations", "home_url", "user_name", "user_email", "user_initials", "booking_base_url", "qr_svg", "loop", "logout_url"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:account-page";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  708 => 387,  706 => 386,  699 => 381,  697 => 380,  692 => 378,  688 => 376,  680 => 374,  678 => 373,  673 => 371,  669 => 370,  665 => 368,  663 => 367,  659 => 365,  655 => 359,  644 => 350,  638 => 345,  617 => 339,  613 => 338,  608 => 336,  601 => 332,  597 => 331,  593 => 329,  591 => 328,  587 => 327,  581 => 324,  576 => 323,  559 => 322,  540 => 305,  532 => 298,  514 => 295,  510 => 294,  507 => 293,  490 => 287,  484 => 283,  482 => 282,  464 => 267,  457 => 263,  450 => 258,  448 => 257,  440 => 251,  414 => 227,  401 => 217,  397 => 216,  391 => 213,  364 => 188,  362 => 187,  357 => 184,  355 => 183,  350 => 180,  348 => 179,  332 => 165,  325 => 159,  323 => 158,  318 => 155,  306 => 150,  299 => 146,  292 => 142,  284 => 136,  278 => 134,  276 => 133,  267 => 127,  262 => 125,  255 => 121,  251 => 120,  247 => 119,  242 => 116,  240 => 115,  236 => 114,  229 => 111,  225 => 110,  219 => 106,  217 => 105,  212 => 103,  200 => 93,  189 => 84,  182 => 79,  180 => 78,  172 => 73,  167 => 70,  165 => 69,  157 => 64,  152 => 61,  150 => 60,  143 => 55,  133 => 47,  127 => 44,  114 => 35,  112 => 34,  106 => 31,  91 => 19,  86 => 16,  81 => 12,  71 => 10,  66 => 9,  62 => 8,  60 => 7,  58 => 6,  55 => 5,  53 => 4,  51 => 3,  49 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:account-page", "themes/custom/cfc_media_hub/components/account-page/account-page.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 1, "for" => 8, "if" => 9, "include" => 34];
        static $filters = ["escape" => 19, "raw" => 227];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "set", 1 => "for", 2 => "if", 3 => "include"],
                [0 => "escape", 1 => "raw"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
