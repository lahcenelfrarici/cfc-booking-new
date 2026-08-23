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

/* cfc_media_hub:confirmation-page */
class __TwigTemplate_208d3281a475d9acbd5ebd9263043480 extends Template
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
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--confirmation-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:confirmation-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:confirmation-page"));
        yield "<style>
  @media print {
    body * { visibility: hidden; }
    #confirmation-card, #confirmation-card * { visibility: visible; }
    #confirmation-card {
      position: fixed;
      inset: 0;
      margin: 24px;
    }
  }
</style>

<div class=\"border-b border-neutral-100 bg-white\">
  <div class=\"w-full max-w-[1440px] mx-auto px-12 h-20 flex items-center justify-between\">
    <a href=\"";
        // line 15
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"flex items-center gap-2 text-[13px] text-neutral-500 hover:text-neutral-900 transition-colors\">
      <img src=\"";
        // line 16
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["logo_url"] ?? null), "html", null, true);
        yield "\" alt=\"CFC Media Hub\" class=\"h-8 w-auto\" />
    </a>
    <span class=\"text-[13px] text-neutral-400\">Reservation confirmed</span>
    <span class=\"w-16\"></span>
  </div>
</div>

<section class=\"bg-[#FCFCFB] min-h-[70vh]\">
  <div class=\"max-w-[760px] mx-auto px-12 py-16 text-center\">
    <div class=\"w-20 h-20 rounded-full bg-[#9F5434]/10 border-4 border-[#9F5434]/20 flex items-center justify-center mx-auto mb-8\">
      ";
        // line 26
        yield from $this->load("cfc_media_hub:icon", 26)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-10 h-10 text-[#9F5434]"]));
        // line 27
        yield "    </div>

    <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#0F6E56] font-semibold mb-4\">
      Confirmed &middot; ";
        // line 30
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["reference"] ?? null), "html", null, true);
        yield "
    </div>
    <h1 class=\"tracking-tight mb-4\" style=\"font-size: 56px; font-weight: 600; line-height: 1.05; letter-spacing: -0.03em;\">
      Reservation confirmed.
    </h1>
    <p class=\"text-neutral-600 leading-relaxed max-w-[480px] mx-auto mb-10\" style=\"font-size: 16px;\">
      Your reservation has been successfully confirmed. Your digital access card is now available. Present it upon arrival at CFC Media Hub.
    </p>

    <div class=\"flex items-center justify-center gap-4 mb-16\" x-data>
      <button
        type=\"button\"
        x-on:click=\"window.print()\"
        class=\"bg-[#9F5434] hover:bg-[#8A4A2E] text-white px-7 py-3.5 rounded-2xl flex items-center gap-2 transition-colors font-semibold text-[14px]\"
      >
        ";
        // line 45
        yield from $this->load("cfc_media_hub:icon", 45)->unwrap()->yield(CoreExtension::toArray(["name" => "download", "size" => "w-4 h-4"]));
        // line 46
        yield "        Download reservation card
      </button>
      <a
        href=\"";
        // line 49
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\"
        class=\"border border-neutral-200 hover:border-neutral-400 text-neutral-700 px-7 py-3.5 rounded-2xl flex items-center gap-2 transition-colors font-medium text-[14px]\"
      >
        Return to homepage
      </a>
    </div>

    <div class=\"text-left\">
      <div class=\"text-[12px] uppercase tracking-wide text-neutral-400 mb-4 text-center font-semibold\">
        Your access card
      </div>

      <div id=\"confirmation-card\" class=\"bg-white rounded-3xl border border-neutral-200 overflow-hidden shadow-[0_24px_60px_-20px_rgba(15,110,86,0.15)]\">
        <div class=\"bg-[#0F6E56] px-8 py-7 flex items-center justify-between\">
          <img src=\"";
        // line 63
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["logo_url"] ?? null), "html", null, true);
        yield "\" alt=\"CFC Media Hub\" class=\"h-14 w-auto brightness-0 invert\" />
          <div class=\"text-right\">
            <div class=\"text-[11px] uppercase tracking-[0.16em] text-white/60 mb-1 font-semibold\">
              Access Card
            </div>
            <div class=\"bg-[#9F5434] text-white px-3 py-1 rounded-full text-[11px] font-bold inline-block\">
              &check; Confirmed
            </div>
          </div>
        </div>
        <div class=\"h-[3px] bg-gradient-to-r from-[#9F5434] via-[#9F5434]/60 to-transparent\"></div>

        <div class=\"grid grid-cols-12 gap-0\">
          <div class=\"col-span-8 p-8\">
            <div class=\"mb-6\">
              <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">Reservation ID</div>
              <div class=\"text-[18px] text-neutral-900 font-bold\">";
        // line 79
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["reference"] ?? null), "html", null, true);
        yield "</div>
            </div>

            <div class=\"grid grid-cols-2 gap-6 mb-6\">
              <div>
                <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">Full Name</div>
                <div class=\"text-[15px] text-neutral-900 font-semibold\">";
        // line 85
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_name"] ?? null), "html", null, true);
        yield "</div>
              </div>
              <div>
                <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">User Type</div>
                <div class=\"text-[15px] text-neutral-900 font-semibold\">";
        // line 89
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["account_type_label"] ?? null), "html", null, true);
        yield "</div>
              </div>
              <div>
                <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">Reserved Space</div>
                <div class=\"text-[15px] text-neutral-900 font-semibold\">";
        // line 93
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["space_label"] ?? null), "html", null, true);
        yield "</div>
              </div>
              <div>
                <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">Organisation</div>
                <div class=\"text-[15px] text-neutral-900 font-semibold\">";
        // line 97
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((array_key_exists("organization", $context)) ? (Twig\Extension\CoreExtension::default(($context["organization"] ?? null), "—")) : ("—")), "html", null, true);
        yield "</div>
              </div>
              <div>
                <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">Date</div>
                <div class=\"text-[15px] text-neutral-900 font-semibold\">";
        // line 101
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["date"] ?? null), "html", null, true);
        yield "</div>
              </div>
              <div>
                <div class=\"text-[11px] uppercase tracking-wide text-neutral-400 mb-1 font-semibold\">Time</div>
                <div class=\"text-[15px] text-neutral-900 font-semibold\">";
        // line 105
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["time"] ?? null), "html", null, true);
        yield " &middot; ";
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["duration"] ?? null), "html", null, true);
        yield "</div>
              </div>
            </div>
          </div>

          <div class=\"col-span-4 p-8 flex flex-col items-center justify-center bg-neutral-50 border-l border-neutral-100\">
            <div class=\"w-28 h-28 border-2 border-dashed border-neutral-300 rounded-xl flex items-center justify-center mb-3\">
              <div class=\"text-center\">
                <div class=\"text-[10px] uppercase tracking-wide text-neutral-400 leading-tight font-bold\">
                  QR<br />Code
                </div>
              </div>
            </div>
            <div class=\"text-[11px] text-neutral-400 text-center\">Scan on arrival</div>
          </div>
        </div>

        <div class=\"px-8 py-4 bg-[#9F5434]/5 border-t border-[#9F5434]/20 flex items-center justify-between\">
          <div class=\"text-[12px] text-neutral-500\">
            Please present this reservation card upon arrival at CFC Media Hub — Main Street, CFC Cube, 2nd Floor, Casablanca Finance City.
          </div>
          <div class=\"text-[11px] text-[#0F6E56] shrink-0 ml-4 font-semibold\">
            cfcmediahub.com
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["home_url", "logo_url", "reference", "user_name", "account_type_label", "space_label", "organization", "date", "time", "duration"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:confirmation-page";
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
        return array (  192 => 105,  185 => 101,  178 => 97,  171 => 93,  164 => 89,  157 => 85,  148 => 79,  129 => 63,  112 => 49,  107 => 46,  105 => 45,  87 => 30,  82 => 27,  80 => 26,  67 => 16,  63 => 15,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:confirmation-page", "themes/custom/cfc_media_hub/components/confirmation-page/confirmation-page.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 26];
        static $filters = ["escape" => 15, "default" => 97];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "include"],
                [0 => "escape", 1 => "default"],
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
