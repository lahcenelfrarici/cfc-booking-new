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

/* cfc_media_hub:booking-review-page */
class __TwigTemplate_b50b81f6e5f0364d7efa6152fc942cbb extends Template
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
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--booking-review-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:booking-review-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:booking-review-page"));
        yield "<div class=\"border-b border-neutral-100 bg-white\">
  <div class=\"w-full max-w-[1440px] mx-auto px-12 h-20 flex items-center justify-between\">
    <a href=\"";
        // line 3
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"flex items-center gap-2 text-[13px] text-neutral-500 hover:text-neutral-900 transition-colors\">
      ";
        // line 4
        yield from $this->load("cfc_media_hub:icon", 4)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-left", "size" => "w-4 h-4"]));
        // line 5
        yield "      Back
    </a>
    ";
        // line 7
        yield from $this->load("cfc_media_hub:journey-steps", 7)->unwrap()->yield(CoreExtension::toArray(["active" => [4]]));
        // line 8
        yield "    <a href=\"";
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"text-[13px] text-neutral-400 hover:text-neutral-700 transition-colors\">Cancel</a>
  </div>
</div>

<section class=\"bg-[#FCFCFB] min-h-[70vh]\">
  <div class=\"max-w-[640px] mx-auto px-12 py-16\">
    <div class=\"mb-10\">
      <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#0F6E56] font-semibold mb-3\">Step 4 · Review your reservation</div>
      <h1 class=\"tracking-tight\" style=\"font-size: 48px; font-weight: 600; letter-spacing: -0.025em;\">
        Review &amp; confirm.
      </h1>
    </div>

    <div class=\"bg-white rounded-3xl border border-neutral-200 overflow-hidden mb-6\">
      <div class=\"px-8 py-5 bg-[#9F5434]/5 border-b border-neutral-100\">
        <div class=\"text-[12px] uppercase tracking-wide text-[#9F5434] font-semibold\">Reservation summary</div>
      </div>
      <div class=\"divide-y divide-neutral-100\">
        <div class=\"px-8 py-4 flex items-center justify-between\">
          <div class=\"text-[13px] text-neutral-400 font-medium\">Space</div>
          <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 28
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["space_label"] ?? null), "html", null, true);
        yield "</div>
        </div>
        <div class=\"px-8 py-4 flex items-center justify-between\">
          <div class=\"text-[13px] text-neutral-400 font-medium\">Date</div>
          <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 32
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["date"] ?? null), "html", null, true);
        yield "</div>
        </div>
        <div class=\"px-8 py-4 flex items-center justify-between\">
          <div class=\"text-[13px] text-neutral-400 font-medium\">Time</div>
          <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 36
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["time"] ?? null), "html", null, true);
        yield " &middot; ";
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["duration"] ?? null), "html", null, true);
        yield "</div>
        </div>
        <div class=\"px-8 py-4 flex items-center justify-between\">
          <div class=\"text-[13px] text-neutral-400 font-medium\">Name</div>
          <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 40
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_name"] ?? null), "html", null, true);
        yield "</div>
        </div>
        <div class=\"px-8 py-4 flex items-center justify-between\">
          <div class=\"text-[13px] text-neutral-400 font-medium\">Account type</div>
          <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 44
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["account_type_label"] ?? null), "html", null, true);
        yield "</div>
        </div>
        <div class=\"px-8 py-4 flex items-center justify-between\">
          <div class=\"text-[13px] text-neutral-400 font-medium\">Reference</div>
          <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 48
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["reference"] ?? null), "html", null, true);
        yield "</div>
        </div>
        <div class=\"px-8 py-4 flex items-center justify-between\">
          <div class=\"text-[13px] text-neutral-400 font-medium\">Pricing</div>
          <div class=\"text-[14px] text-[#9F5434] font-bold\">";
        // line 52
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["price_label"] ?? null), "html", null, true);
        yield "</div>
        </div>
      </div>
    </div>

    <div class=\"bg-white rounded-3xl border border-neutral-200 p-8 mb-6\">
      ";
        // line 58
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["guests_form"] ?? null), "html", null, true);
        yield "
    </div>

    <div class=\"flex items-center justify-between gap-4\">
      <a href=\"";
        // line 62
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["edit_url"] ?? null), "html", null, true);
        yield "\" class=\"text-[13px] text-neutral-400 hover:text-red-500 underline underline-offset-2 transition-colors\">
        Edit reservation
      </a>
      <a href=\"";
        // line 65
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["confirm_url"] ?? null), "html", null, true);
        yield "\" class=\"bg-[#9F5434] hover:bg-[#8A4A2E] text-white py-3.5 px-8 rounded-2xl flex items-center justify-center gap-2 transition-colors font-semibold text-[14px]\">
        ";
        // line 66
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["confirm_label"] ?? null), "html", null, true);
        yield "
        ";
        // line 67
        yield from $this->load("cfc_media_hub:icon", 67)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4"]));
        // line 68
        yield "      </a>
    </div>
  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["home_url", "space_label", "date", "time", "duration", "user_name", "account_type_label", "reference", "price_label", "guests_form", "edit_url", "confirm_url", "confirm_label"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:booking-review-page";
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
        return array (  163 => 68,  161 => 67,  157 => 66,  153 => 65,  147 => 62,  140 => 58,  131 => 52,  124 => 48,  117 => 44,  110 => 40,  101 => 36,  94 => 32,  87 => 28,  63 => 8,  61 => 7,  57 => 5,  55 => 4,  51 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:booking-review-page", "themes/custom/cfc_media_hub/components/booking-review-page/booking-review-page.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 4];
        static $filters = ["escape" => 3];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "include"],
                [0 => "escape"],
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
